<?php

namespace App\Http\Controllers;

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

    public function showAdmin(){
        return view('admin.users', ['users' => User::all()] );
    }

    public function showAdminUsers(){
        return view('admin.users', ['users' => User::all()] );
    }

    public function showAdminUserEdit($id){
        //return view('user_edit', ['id' => $id]);
    }

    public function AdminUserDelete($id){
        //return view('admin.admin_user_delete', ['id' => $id]);
    }

    public function showAdminUserCreate(){
        return view('admin.create_user');
    }

    public function createUser(Request $request){
        
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
    
            $credentials = $request->only('email', 'password');
    
            if (Auth::attempt($credentials)) { 
                return redirect()->route('login');
            } else {
                return redirect()->back()->withError('Creation failed.')->withInput();
            }

    }

}
