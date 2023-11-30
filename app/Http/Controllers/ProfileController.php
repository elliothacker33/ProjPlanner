<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class ProfileController extends Controller
{
    public function showProfile(User $user) : View
    {


        if (!$user) {
            abort(404, 'User profile page not found.');
        }

        return view('profile_pages.profile', [
            'usrId' => $user->id,
            'profileName' => $user->name,
            'profileEmail' => $user->email]
        ); // Add image here.
    }
    public function showEditProfile(User $user) : View
    {

        if (!$user) {
            abort(404, 'User profile page not found.');
        }

        $this->authorize('update', $user);

        return view('profile_pages.edit-profile',['user'=>$user]);
    }

    
    public function updateProfile(Request $request, User $user)
    {

        $rules = [
            'name' => 'required|string|max:20',
            'old_password' => 'required_with:new_password|min:8',
            'new_password' => 'min:8|max:255',
        ];
    
        $customErrors = [
            'name.max' => 'The name must not exceed 20 characters.',
            'old_password.required_with' => 'Please provide the old password when updating the password.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $customErrors);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $this->authorize('update', $user);
    
        $user->name = $request->name;
    
        if ($request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('error', 'The old password is incorrect');
            }

            $user->password = Hash::make($request->new_password);
        }
        $user->save();
        return redirect()->route('profile', ['user' => $user]);

    }
    
}