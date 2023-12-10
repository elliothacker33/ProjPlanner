<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function searchTasks(Request $request)
    {
        $project = Project::find($request->input('project'));

        if ($project == null)
            return response()->json(['error' => 'Project with specified id not found'], 404);

        $this->authorize('create', [Task::class, $project]);

        $searchedTasks = $project->tasks()
            ->whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$request->input('query')])
            ->orderByRaw("ts_rank(tsvectors, plainto_tsquery('english', ?)) DESC", [$request->input('query')])
            ->get();

        return response()->json($searchedTasks);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(Request $request, Project $project)
    {
        $this->authorize('create', [Task::class,  $project]);
        return view('pages.' . 'createTask')->with(['project'=>$project->id, 'users'=>$project->users,'tags'=>$project->tags]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request, Project $project)
    {
        // Validate input
        $this->authorize('create', [Task::class, $project]);
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:100|',
            'description' => 'required|string|min:10|max:1024',
            'deadline' => 'nullable|date|after_or_equal:today',
            'users' => 'nullable',
            'tags' => 'nullable'
        ]);
        // Add Policy thing


        $task = new Task();
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->opened_user_id= Auth::user()->id;
        $task->deadline = $validated['deadline'];
        $task->project_id = $project->id;
        $task->save();

        $task->assigned()->attach(Auth::user()->id);
        $task->tags()->attach($validated['tags']);

        return redirect()->route('task',['project'=>$project,'task'=>$task]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        $project_task = $task->project;
        
        if ($task == null || $project_task == null)
            return abort(404);

        $this->authorize('view',[$task::class,$task]);
        $users = $task->assigned;

        $tags = $task->tags;
        $creator = User::find($task->opened_user_id);
        return view('pages.task',['project' => $project_task, 'task'=>$task, 'assign'=>$users,'tags'=>$tags,'creator'=>$creator]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    /**
     * Mark a task as closed
     */
    public function finish(Request $request, Project $project, Task $task) {
        $user = User::find($request->input('closed_user_id'));

        if ($user == null)
            return abort(404);

        $this->authorize('apiUpdate', [Task::class, $user, $project, $task]);

        $task->status = 'closed';
        $task->closed_user_id = $user->id;
        $task->endtime = now();
        $task->save();

        return response('Task finished successfully', 200);
    }
}
