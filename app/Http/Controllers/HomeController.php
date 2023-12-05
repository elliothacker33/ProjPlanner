<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{  
    
    public function showHome(Request $request, $usrId)
    {   
        $user = $request->user();

        if ($user === null) {
            return $this->showLanding();
        }
    
        // TODO: Check if the user is admin
    
        // TODO: Check if the user is blocked
        if($usrId == $user->id){
            if($user->is_admin)  return redirect()->route('admin');
            $projects = $this->getProjects($usrId);
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



    public function getProjects($usrId)
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