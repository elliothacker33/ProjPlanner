<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\ProjectController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Home


Route::redirect("/","/landing");

// Recover password route

 // Forgot password form
Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    
// Handle forgot password form submission
Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('This email address is not registered.')]);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );


        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');


Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');


     
    Route::post('/reset-password', function (Request $request) {
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => [
                'required',
                'min:8',
                Rule::in([$request->input('password')]),
            ],
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
        dd(Password::PASSWORD_RESET);
        
        dd($status === Password::PASSWORD_RESET);
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    :  back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');

//Static Pages
Route::get('{page}', [StaticController::class, 'show'])->whereIn('page', StaticController::STATIC_PAGES)->name('static');

// Admin
Route::controller(UserController::class)->group(function(){
    Route::get('users/search', 'index')->name('search_users');
});
Route::controller(AdminController::class)->group(function () {
    Route::redirect('/admin', '/admin/users')->name('admin');
    Route::get('/admin/users', 'show')->name('admin_users');
    Route::get('/admin/users/create', 'create');
    Route::post('/admin/users/create', 'store')->name('admin_user_create');
});

Route::controller(TaskController::class)->group(function(){
    Route::get('project/{projectId}/tasks/search', 'index')->name('search_tasks');
});
Route::prefix('/project/{projectId}')->group(function (){
    Route::get('',[ProjectController::class,'show'])->name('project')->whereNumber('projectId');
    Route::get('/team',[ProjectController::class,'show_team'])->name('team');
    Route::post('team/add',[ProjectController::class,'add_user'])->name('addUser');
    Route::prefix('/task')->controller(TaskController::class)->group(function (){
        Route::get('/{id}', 'show')->where('id','[0-9]+')->name('task');
        Route::get('/new', 'create')->name('createTask');
        Route::post('/new', 'store')->name('newTask');
    });
});
// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// Sign-up
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register','showRegistrationForm')->name('register');
    Route::post('/register', 'register')->name('create_account');
});
// Profile
Route::controller(ProfileController::class)->group(function () {
    Route::get('/user-profile/{usrId}','showProfile')->name('profile');
    Route::put('/user-profile/{usrId}/edit','updateProfile')->name('update_profile');
    Route::get('/user-profile/{usrId}/edit','showEditProfile')->name('edit_profile');
});

// Files 
Route::controller(FileController::class)->group(function () {
    Route::post('/file/upload','upload')->name('upload_profile_file');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/homepage/{usrId}','showHome')->name('home');
    Route::get('/landing', 'showLanding')->name('landing');
});
Route::controller(ProjectController::class)->group(function () {
    Route::get('/project/new' , 'create')->name('show_new');
    Route::post('/project/new', 'store')->name('action_new');
    Route::delete('/project/{projectId}', 'destroy')->where('projectId', '[0-9]+')->name('delete_project');
    Route::get('/project/{projectId}/tasks', 'showTasks')->where('projectId', '[0-9]+')->name('show_tasks');
    Route::get('/project/{projectId}/edit', 'edit')->whereNumber('projectId')->name('show_edit_project');
    Route::put('/project/{projectId}/edit', 'update')->whereNumber('projectId')->name('action_edit_project');
});