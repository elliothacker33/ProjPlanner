<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Project $project)
    {
        
        if ($project == null) {
            if ($request->ajax())
                return response()->json(['error' => 'Project with specified id not found'], 404);
            else
                return abort(404);
        }

        $this->authorize('view_forum', [Project::class, $project]);

        $posts = $project->posts()->orderBy('submit_date', 'asc')->cursorPaginate(3);

        if($request->ajax()) {
            $response = view('pages.forum', ['project'=>$project, 'posts'=>$posts])->render();
            return response()->json(['html' => $response]);
        }
        else
            return view('pages.forum', ['project'=>$project, 'posts'=>$posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        
        $this->authorize('create', [Project::class, $project]);

        $request->validate([
            'content' => 'required|string|max:1024',
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->submit_date = date('Y-m-d');
        $post->last_edited = null;
        $post->user_id = Auth::user()->id;
        $post->project_id = $project->id;
        $post->save();
        
        return redirect()->route('forum', ['project' => $project]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        $this->authorize('update', [Post::class, $post]);

        return view('pages.editPost', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', [Post::class, $post]);

        $request->validate([
            'content' => 'required|string|max:1024',
        ]);

        $post->content = $request->content;
        $post->last_edited = date('Y-m-d');
        $post->save();

        return redirect()->route('forum', ['project' => $post->project]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $this->authorize('delete', [Post::class, $post]);

        $post->delete();

        return redirect()->route('forum');
    }
}
