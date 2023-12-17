<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', [Post::class, $post]);

        $post->delete();

        return redirect()->route('forum');
    }
}
