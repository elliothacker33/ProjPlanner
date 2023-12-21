<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AdminController extends Controller
{

    public function show(Request $request){
        $this->authorize('view_admin',[User::class]);
        $query = $request->input('query');
        $users = User::query()->count();
        if( $query)
            return view('admin.users', ['users' => app(UserController::class)->searchUsers($request),'query'=>$query,'registrations'=>$users] );
        return view('admin.users', ['users' => User::query()->paginate(10)->withQueryString(),'query'=>$query,'registrations'=>$users] );
    }

    public function create(){
        $this->authorize('create_admin',[User::class]);
        return view('admin.create_user');
    }


    public function store(Request $request)
    {

        $this->authorize('create_admin', [User::class]);

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
