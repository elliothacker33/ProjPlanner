<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, int $projectId)
    {

        $project = Project::find($projectId);
        $this->authorize('create', [Task::class,  $project]);
        $searchTerm = '%'.$request->searchTerm.'%';
        $likeSearchTerm = '*' . $request->searchTerm . '*';
        $tasks = Task::whereRaw("title Like ?  ",[$searchTerm])->get();
        // $questions = DB::unprepared("SELECT * FROM Users, plainto_tsquery('portuguese','$searchTerm') query WHERE tsvectors @@ query ORDER BY rank DESC;");
        // $users = DB::raw("SELECT * FROM Users");

        if($request->ajax()){
            return view('partials.displayTasks', ['tasks' => $tasks,'project'=>$project] );
        }
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(Request $request, int $projectId)
    {

        $project = Project::find($projectId);
        $this->authorize('create', [Task::class,  $project]);
        $res = DB::table('project_tag')
            ->join('tags', 'tags.id', '=', 'project_tag.tag_id')
            ->where('project_tag.project_id','=',$projectId)->get();
        return view('pages.' . 'createTask')->with(['projectId'=>$projectId, 'users'=>$project->users,'tags'=>$res]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request, int $projectId)
    {
        // Validate input
        $project = Project::find($projectId);
        $this->authorize('create', [Task::class,  $project]);
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
        $task->save();

        DB::insert('insert into project_task (task_id, project_id) values (?, ?)', [$task->id, $projectId]);
        if($validated['tags'])DB::insert('insert into tag_task (tag_id, task_id) values (?, ?)', [$validated['tags'], $task->id]);
        if($validated['users']) DB::insert('insert into task_user (user_id, task_id) values (?, ?)', [$validated['users'], $task->id]);

        return redirect()->route('task',['projectId'=>$projectId,'id'=>$task->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $projectId, int $taskId)
    {
        $task=Task::find($taskId);
        $project_task = DB::table('project_task')
            ->where('task_id','=',$taskId)
            ->where('project_id','=',$projectId)->get();

        if ($task == null || $project_task->isEmpty())
            return abort(404);

        $this->authorize('view',[$task::class,$task]);
        $users = $task->assigned;

        $tags = DB::table('tag_task')
            ->join('tags','tag_task.tag_id','=','tags.id')
            ->where('task_id','=',$taskId)->get();
        $creator = User::find($task->opened_user_id);
        return view('pages.task',['task'=>$task, 'assign'=>$users,'tags'=>$tags,'creator'=>$creator]);
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
}
