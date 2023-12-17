<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewUserProjects',Project::class);
        $projects = $this->search($request);
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
                ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$request->input('query')])
                ->get();
        }else $searchedProjects = $projects->get();

        if ($request->ajax())
            return response()->json($searchedProjects);
        else
            return $searchedProjects;
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

        $this->authorize('view',[Project::class,$project]);
        $users = $project->users;

        $completed_tasks = $project->tasks()
            ->where('tasks.status','=','closed')
            ->count();
        
        $open_tasks = $project->tasks()
            ->where('tasks.status','=','open')
            ->count();

        $all_task = $completed_tasks + $open_tasks;
        return view('pages.project',['project'=>$project, 'team'=>$users->slice(0,4),'allTasks'=>$all_task, 'completedTasks'=>$completed_tasks]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {   
        if ($project == null)
            return abort(404);

        $this->authorize('update', [Project::class, $project]);

        return view('pages.editProject', ['project'=>$project]);
    }
    public function show_team(Project $project)

    {
        $this->authorize('view',[Project::class,$project]);
        return view('pages.team',['team'=>$project->users, 'project'=>$project]);
    }
    public function add_user(Request $request, Project $project)

    {
        $this->authorize('update',[Project::class,$project]);
        $user = User::where('email', $request->email)->first();
        if(!$user)return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        if($user->is_admin)return back()->withErrors([
            'email' => 'Admins cannot be part of a project',
        ])->onlyInput('email');
        if($user->is_block)return back()->withErrors([
            'email' => 'User is blocked',
        ])->onlyInput('email');
        $users= $project->users;
        $memberExist=false;
        foreach ($users as $member){
            if($member->id === $user->id) $memberExist= true;
        }
        if($memberExist) return back()->withErrors([
            'email' => 'Member already in the project',
        ])->onlyInput('email');

        $project->users()->attach($user->id);

        return redirect()->route('team',['team'=>$project->users,'project'=>$project]);
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

        return redirect()->route('home', ['projects' => $projects,'user'=>Auth::id()]);
        // TODO: redirect to "My projects page"
        // return redirect()->route('my_projects');
    }


    public function showTasks(Request $request, Project $project)
    {
        if ($project == null) {
            if ($request->ajax())
                return response()->json(['error' => 'Project with specified id not found'], 404);
            else
                return abort(404);
        }

        $this->authorize('view', [Project::class, $project]);

        $tasks = $project->tasks;
        
        if ($request->ajax())
            return response()->json($tasks);
        else
            return view('pages.tasks', ['project'=>$project, 'tasks'=>$tasks]);
    }
}
