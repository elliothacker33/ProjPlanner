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
    Route::get('/admin/users/create', 'create');
    Route::post('/admin/users/create', 'store')->name('admin_user_create');
});

Route::controller(TaskController::class)->group(function(){
    Route::get('project/{project}/tasks/search', 'index')->name('search_tasks');
});
Route::prefix('/project/{project}')->where([ 'project'=>'[0-9]+'])->group(function (){
    Route::get('',[ProjectController::class,'show'])->name('project')->whereNumber('projectId');
    Route::get('/team',[ProjectController::class,'show_team'])->name('team');
    Route::post('team/add',[ProjectController::class,'add_user'])->name('addUser');
    Route::prefix('/task')->controller(TaskController::class)->group(function (){
        Route::get('/{task}', 'show')->where('task','[0-9]+')->name('task');
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
    Route::get('/user-profile/{user}','showProfile')->name('profile');
    Route::put('/user-profile/{user}/edit','updateProfile')->name('update_profile');
    Route::get('/user-profile/{user}/edit','showEditProfile')->name('edit_profile');
});



Route::controller(HomeController::class)->group(function () {
    Route::get('/homepage/{user}','showHome')->name('home');
    Route::get('/landing', 'showLanding')->name('landing');
});
Route::controller(ProjectController::class)->group(function () {
    Route::get('/project/new' , 'create')->name('show_new');
    Route::post('/project/new', 'store')->name('action_new');
    Route::delete('/project/{project}', 'destroy')->where('project', '[0-9]+')->name('delete_project');
    Route::get('/project/{project}/tasks', 'showTasks')->where('project', '[0-9]+')->name('show_tasks');
    Route::get('/project/{project}/edit', 'edit')->whereNumber('project')->name('show_edit_project');
    Route::put('/project/{project}/edit', 'update')->whereNumber('project')->name('action_edit_project');
});