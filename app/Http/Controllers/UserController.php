<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function searchUsers(Request $request)
    {
        $searchTerm = '%' . $request->input('query') . '%';

        $project = $request->input('project');
        $query = null;
        if ($project !== null) {
            $query = Project::find($project)->users();
        }
        else{
            $query = User::query();
        }
        $users = $query->where(function ($query) use ($searchTerm) {
            $query->where('email', 'like', $searchTerm)
                ->orWhere('name', 'like', $searchTerm);
        });
        if ($request->ajax())
            return response()->json($users->get());
        else {
            if($project ===null)
                return $users->paginate(10);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize("delete", $user);

        $user->delete();

        return redirect()->route('init_page');
    }
}
