<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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

Route::get('', [HomeController::class,'show'])->name('home');

Route::redirect('/', '/home')->name('home');

Route::get('{page}', [StaticController::class, 'show'])->whereIn('page', StaticController::STATIC_PAGES)->name('static');

// Admin
Route::controller(AdminController::class)->group(function () {

    //Route::get('/admin', 'showAdmin')->name('admin');
    Route::redirect('/admin', '/admin/users')->name('admin');
    Route::get('/admin/users', 'showAdminUsers')->name('admin_users');
    Route::get('/admin/users/{id}/edit', 'showAdminUserEdit')->name('admin_user_edit');
    //Route::get('/admin/users/{id}/delete', 'adminUserDelete')->name('admin_user_delete');
    Route::get('/admin/users/create', 'showAdminUserCreate')->name('admin_user_create');
    Route::post('/admin/users/create', 'adminUserCreate');
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

