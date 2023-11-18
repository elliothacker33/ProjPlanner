<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{

    public const STATIC_PAGES = [
        'home',
        'about',
        'contact',
        'faq',
    ];

    public function show(Request $request)
    {
        return response()->view('static.' . $request->path());
    }
}
