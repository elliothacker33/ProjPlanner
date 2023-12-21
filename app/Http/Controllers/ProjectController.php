<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewUserProjects',Project::class);

        $projects = $this->search($request);

        if ($request->session()->has('message')) {
            return view('home.home',['projects'=>$projects,'query'=>$request->input('query')])->with('message', $request->session()->get('message'));
        }
        else
            return view('home.home',['projects'=>$projects,'query'=>$request->input('query')]);
    }

    public function search(Request $request){
        $user = $request->user();
        if($user->is_admin){
            $projects = Project::query();
        }else{
            $projects = $user->projects();
        }
        if($request->input('query')) {
            $searchedProjects = $projects->with('coordinator')
                ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$request->input('query')])
                ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$request->input('query')]);
        }else $searchedProjects = $projects;

        if ($request->ajax())
            return response()->json($searchedProjects->get());
        else
            return $searchedProjects->paginate(10)->withQueryString();
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        return view('pages.newProjectForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:100|',
            'description' => 'required|string|min:10|max:1024',
            'deadline' => 'nullable|date|after_or_equal:' . date('d-m-Y'),
        ]);

        $this->authorize('create', Project::class);

        $project = new Project();
        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->deadline = isset($validated['deadline']) ? $validated['deadline'] : null;
        $project->user_id = Auth::user()->id;
        $project->save();

        $project->users()->attach(Auth::user()->id);

        return redirect()->route('project', ['project' => $project]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {

        if ($project == null)
            return abort(404);

        $this->authorize('view', [Project::class, $project]);
        $users = $project->users;

        $completed_tasks = $project->tasks()
            ->where('tasks.status', '=', 'closed')
            ->count();

        $open_tasks = $project->tasks()
            ->where('tasks.status', '=', 'open')
            ->count();

        $all_task = $completed_tasks + $open_tasks;
        return view('pages.project', ['project' => $project, 'team' => $users->slice(0, 4), 'allTasks' => $all_task, 'completedTasks' => $completed_tasks]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if ($project == null)
            return abort(404);

        $this->authorize('update', [Project::class, $project]);

        return view('pages.editProject', ['project' => $project]);
    }
    public function show_team(Project $project)

    {
        $this->authorize('view', [Project::class, $project]);
        return view('pages.team', ['team' => $project->users, 'project' => $project]);
    }
    public function add_user(Request $request, Project $project)

    {
        $this->authorize('update', [Project::class, $project]);
        $user = User::where('email', $request->email)->first();
        if (!$user) return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        if ($user->is_admin) return back()->withErrors([
            'email' => 'Admins cannot be part of a project',
        ])->onlyInput('email');
        if ($user->is_block) return back()->withErrors([
            'email' => 'User is blocked',
        ])->onlyInput('email');
        
        if($project->users->contains($user)) return back()->withErrors([
            'email' => 'Member already in the project',
        ])->onlyInput('email');

        $project->users()->attach($user->id);

        return redirect()->route('team', ['team' => $project->users, 'project' => $project]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:100|',
            'description' => 'required|string|min:10|max:1024',
            'deadline' => 'nullable|date|after_or_equal:' . date('d-m-Y'),
        ]);

        $this->authorize('update', [Project::class, $project]);

        $project->title = $validated['title'];
        $project->description = $validated['description'];
        $project->deadline = isset($validated['deadline']) ? $validated['deadline'] : null;
        $project->save();

        return redirect()->route('project', ['project' => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        if ($project == null)
            return abort(404);

        $this->authorize('delete', [Project::class, $project]);

        $project->delete();

        $projects = Project::all();

        return redirect()->route('home', ['projects' => $projects, 'user' => Auth::id()]);
        // TODO: redirect to "My projects page"
        // return redirect()->route('my_projects');
    }


    public function showTasks(Request $request, Project $project)
    {
        if ($project == null) {
            if ($request->ajax())
                return response()->json(['error', 'Project with specified id not found']);
            else
                return abort(404);
        }

        $this->authorize('view', [Project::class, $project]);

        $tasks = $project->tasks()->with('created_by')->paginate(10)->withQueryString();
        //dd($tasks);
        $open = $project->tasks()->where('status','=','open')->count();
        $closed = $project->tasks()->where('status','=','closed')->count();
        $canceled = $project->tasks()->where('status','=','canceled')->count();
        if($request->input('query')) $tasks = app(TaskController::class)->searchTasks($request,$project);

        if ($request->ajax())
            return response()->json($tasks);
        else
            return view('pages.tasks', ['project'=>$project, 'tasks'=>$tasks, 'open'=>$open,'closed'=>$closed,'canceled'=>$canceled, 'query'=>$request->input('query')]);
    }


public function remove_user(Request $request, Project $project) {
        $removedUser = User::find($request->user);
        
        if ($removedUser == null) {
            if ($request->ajax())
                return response()->json(['error' => 'User to remove from project not found'], 404);
            else
                abort(404, 'User to remove from project not found');
        }

        $this->authorize('removeUser', [Project::class, $project, $removedUser]);

        $removedUser->assign()->detach();
        $project->users()->detach($removedUser->id);

        if (Auth::user() == $removedUser)
            return redirect()->route('home', ['projects' => $removedUser->projects,'user'=>Auth::id()]);
        else
            return response()->json(['message' => 'User has been successfully removed'], 200);
    }

    public function send_email_invite(Request $request, Project $project)
    {
        $this->authorize('send_invite', [Project::class, $project]);

        $request->validate([
            'email' => 'required|email|',
        ]);

        $lastInviteToken = DB::table('invites')
            ->where('email', $request->email)
            ->where('project_id', $project->id)
            ->orderBy('invite_date', 'desc')
            ->first();

        if ($lastInviteToken && Date::parse($lastInviteToken->invite_date)->diffInMinutes(now()) < 5) {
            return response()->json(['message' => 'Invite to ' . $request->email . 'already sent within the last 5 minutes'], 429);
        }
        
        $token = Str::random(64);
  
        DB::table('invites')->insert([
            'email' => $request->email, 
            'project_id' => $project->id,
            'token' => $token,
            'invite_date' => now(),
        ]);
    
        $mailData = [
            'email' => $request->email,
            'token' => $token,
            'subject' => "Invite to join project",
        ];
        
        MailController::send($mailData);
        
        return response()->json(['message' => 'Invite to ' . $request->email . ' sent successfully'], 200);
    }
}
