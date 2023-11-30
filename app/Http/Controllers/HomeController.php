<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{  
    
    public function showHome(Request $request, User $user)
    {   
        $authenticatedUser = $request->user();

        if ($authenticatedUser === null) {
            return $this->showLanding();
        }
    
        // TODO: Check if the user is admin
    
        // TODO: Check if the user is blocked
        if($user->id == $authenticatedUser->id){
            if($authenticatedUser->is_admin)  return redirect()->route('admin');
            $projects = $this->getProjects($user->id );
            return view('home.home', compact('projects'));
        }
        else{
            abort(403);
        }
    }
    
    public function showLanding()
    {
        return view("static_pages.landing");

    }
        # TODO check if user is blocked



    public function getProjects(int $usrId)
    {
        $user = User::find($usrId);

        if ($user) {
            $projects = $user->projects;
            return $projects;
        } else {
            return [];

        }
    }
}




?>