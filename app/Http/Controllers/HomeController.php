<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
class HomeController extends Controller
{  
    
    public function showHome(Request $request, $usrId)
    {   
        $user = $request->user();
    
        // Redirect to landing page if the user is not authenticated
        if ($user === null) {
            return $this->showLanding();
        }
    
        // TODO: Check if the user is admin
    
        // TODO: Check if the user is blocked
        if($usrId == $user->id){
            $projects = $this->getProjects($usrId);
            return view('home.home', compact('projects'));
        }
        else{
            abort(404);
        }
    }
    
    public function showLanding()
    {
        return view("static_pages.landing");
    }
    

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