<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function show(Request $request)
    {

        $user = $request->user();
        #tens de dar redirect
        if ($user === null) {
            return redirect('/home');
        }

        # TODO check if user is admin

        # TODO check if user is blocked

        else {
            return redirect('/home');
        }
    }
}
