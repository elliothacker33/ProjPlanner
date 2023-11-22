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

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ProjectController;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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

//Static Pages
Route::get('{page}', [StaticController::class, 'show'])->whereIn('page', StaticController::STATIC_PAGES)->name('static');

// Admin
Route::controller(UserController::class)->group(function(){
    Route::get('users/search', 'index')->name('search_users');
});
Route::controller(AdminController::class)->group(function () {
    Route::redirect('/admin', '/admin/users')->name('admin');
    Route::get('/admin/users', 'show')->name('admin_users');
    Route::get('/admin/users/create', 'create')->name('admin_user_create');
    Route::post('/admin/users/create', 'store');
});


Route::prefix('/project/{projectId}')->group(function (){
    Route::get('',[ProjectController::class,'show'])->name('project')->whereNumber('projectId');
    Route::get('/team',[ProjectController::class,'show_team'])->name('team');
    Route::post('team/add',[ProjectController::class,'add_user'])->name('addUser');
    Route::prefix('/task')->controller(TaskController::class)->group(function (){
        Route::get('/{id}', 'show')->where('id','[0-9]+')->name('task');
        Route::get('/new', 'create');
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



Route::controller(HomeController::class)->group(function () {
    Route::get('/homepage/{usrId}','showHome')->name('home');
    Route::get('/landing', 'showLanding')->name('landing');
});
Route::controller(ProjectController::class)->group(function () {
    Route::get('/project/new' , 'create')->name('show_new');
    Route::post('/project/new', 'store')->name('action_new');
    Route::delete('/project/{projectId}', 'destroy')->where('projectId', '[0-9]+')->name('delete_project');
});