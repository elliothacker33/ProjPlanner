<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\ProjectNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
DB::enableQueryLog();
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
            $this->authorize('viewTeam', [User::class,Project::find($project)]);
            $query = Project::find($project)->users();
        }
        else{
            $this->authorize('viewAny',User::class);
            $query = User::query();
        }
        $users = $query->where(function ($query) use ($searchTerm) {
            $query->where('email', 'like', $searchTerm)
                ->orWhere('name', 'like', $searchTerm)->with('getProfileImage');
        });
        if ($request->ajax())

            return response()->json($users->get());
        else {
            if($project ===null)
                return $users->paginate(10)->withQueryString();
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
    public function getUserNotification(Request $request){
        if(!$request->user()) abort(404, 'user not found');

        return response()->json(
            [
                'projectNotifications'=>$request->user()->projectNotifications()->with('project')->get(),
                'taskNotifications' =>$request->user()->taskNotifications()->with('task.project')->get(),
                'postNotifications'=>$request->user()->postNotifications()->get(),
                'inviteNotifications'=>$request->user()->inviteNotifications()->with('project')->get(),
                'commentNotifications'=>$request->user()->commentNotifications()->with('comment.task.project')->get()
            ]
        );
    }
}
