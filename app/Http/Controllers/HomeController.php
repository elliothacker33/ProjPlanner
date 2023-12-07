<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if($user){
            if($user->is_admin) return redirect()->route('admin');
            return redirect()->route('projects',['user'=>$user->id]);
        }
        return view('static.landing');
    }

        # TODO check if user is blocked




}




?>