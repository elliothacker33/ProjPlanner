<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class ProfileController extends Controller
{
    public function showProfile($usrId) : View
    {
        $user = User::find($usrId);

        if (!$user) {
            abort(404, 'User profile page not found.');
        }
        
        return view('profile_pages.profile', [
            'usrId' => $usrId,
            'profileName' => $user->name,
            'profileEmail' => $user->email,
            'isAdmin' => $user->is_admin,
            'tasks' => $user->tasks ? $user->tasks : []]
        ); // Add image here.
    }
    public function showEditProfile($usrId) : View
    {
        return view('profile_pages.edit-profile',['usrId'=>$usrId]);
    }

    
    public function updateProfile(Request $request, $usrId)
    {
        $rules = [
            'name' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email,' . $usrId, 
            ],
            'oldp' => 'required_with:newp|min:8',
            'newp' => 'min:8|max:255',
        ];
    
        $customErrors = [
            'name.max' => 'The name must not exceed 20 characters.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'oldp.required_with' => 'Please provide the old password when updating the password.',
            'newp.confirmed' => 'The new password confirmation does not match.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $customErrors);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = User::find($usrId);
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->filled('newp')) {
            if (!Hash::check($request->oldp, $user->password)) {
                return redirect()->back()->with('error', 'The old password is incorrect');
            }
    
            $user->password = Hash::make($request->newp);
        }
        $user->save();
        return redirect()->route('show_profile', ['usrId' => $usrId]);

    }
    
}