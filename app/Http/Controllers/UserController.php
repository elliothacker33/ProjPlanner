<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function searchUsers(Request $request)
    {
        $searchTerm = '%'.$request->input('query').'%';
        $users = User::whereRaw("email Like ?  OR Name Like ? ", [$searchTerm, $searchTerm])->get();

        return response()->json($users);
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
    public function destroy(Request $request, User $user){   

    $this->authorize("delete", $user);

    $request->validate([
        'password' => 'required|string|',
    ]);
    if (Hash::check($request->input('password'), $user->password)) {
    
        $user->delete();
        
        return redirect()->route('login')->with('delete_user_success', 'Your user account was deleted successfully');
    } else {
        return redirect()->back()->with('password','Incorrect password');
    }
}
}
