<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = '%'.$request->searchTerm.'%';
        $likeSearchTerm = '*' . $request->searchTerm . '*';
        $users = User::whereRaw('(tsvectors @@ plainto_tsquery(\'portuguese\', ?))', [$request->searchTerm])
            ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'portuguese\', ?)) DESC', [$request->searchTerm])->get();
        $users = User::whereRaw("email Like ?  OR Name Like ? ",[$searchTerm,$searchTerm])->get();
        // $questions = DB::unprepared("SELECT * FROM Users, plainto_tsquery('portuguese','$searchTerm') query WHERE tsvectors @@ query ORDER BY rank DESC;");
        //$users = DB::raw("SELECT * FROM Users");

        if($request->ajax()){
            return view('partials.displayUsers', ['users' => $users] );
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
