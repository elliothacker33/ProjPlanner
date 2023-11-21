<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    
    public function show_users(array $users, int $page){

        return view('admin.users', ['users' => $users], ['page' => $page]);

    }

    public function select_users(array $users, int $page){

        $users_page = [];

        for ($i = ($page*10)-10; $i < $page*10; $i++){
            array_push($users_page, $users[$i]);
        }

        return $this->show_users($users_page, $page);

    }

    public function create_user(Request $request){
        //
    }

    public function update_user(Request $request){
        //
    }

    public function delete_user(Request $request){
        //
    }


}
