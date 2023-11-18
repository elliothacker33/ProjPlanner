<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function show(Request $request)
    {

        $user = $request->user();

        if ($user === null) {
            return response()->view('static.home');
        }

        # TODO check if user is admin

        # TODO check if user is blocked

        else {
            return response()->view('projects');
        }
    }
}
