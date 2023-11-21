<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function show(Request $request)
    {

        $user = $request->user();

        if ($user === null) {
            return redirect('/home');
        }

        # TODO check if user is blocked

        else if ($user->is_admin) {
            return redirect('/admin');
        }

        else {
            return redirect('/home'); #TODO change to projects
        }
    }
}
