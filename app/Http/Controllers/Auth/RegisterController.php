<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\FileController;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm()
    {

        if (Auth::check())
            return redirect()->route('profile',['user'=> Auth::user()]);

        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {    
        $rules = [
        'name' => 'required|string|max:20',
        'email' => [
            'required',
            'email',
            'max:100',
            'unique:users'
        ],
        'password' => 'required|min:8|max:255|confirmed',
        ];
        $custom_errors = [
            'name.max' => 'The name must not exceed 20 characters.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'password.confirmed' => 'The password confirmation does not match.'
        ];
    
        $validator = Validator::make($request->all(), $rules, $custom_errors);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user-> save();
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) { 
            return redirect()->route('login');
        } else {
            return redirect()->back()->withError('Register failed.')->withInput();
        }
    }
}
