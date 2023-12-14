<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AdminController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('admin');
    }

    public function show(){
        $this->authorize('view_admin',[User::class]);
        return view('admin.users', ['users' => User::all()] );
    }

    public function create(){
        $this->authorize('create_admin',[User::class]);
        return view('admin.create_user');
    }


    public function store(Request $request){

        $this->authorize('create_admin',[User::class]);
        
        $rules = [
            'name' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users'
            ],
            'password' => 'required|min:8|max:255|confirmed',
            'is_admin' => 'required|boolean',
            ];
        
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_admin' => $request->is_admin,
            ]);
            return redirect()->route('admin');

    }

}
