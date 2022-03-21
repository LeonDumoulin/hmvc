<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Dashboard\Auth\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Admin Login
Route::get('login', 'Auth\LoginController@index')->middleware(['guest:web'])->name('admin.login.view');
Route::post('login','Auth\LoginController@login')->name('admin.login');
// Admin Logout
Route::any('logout', 'Auth\LoginController@logout')->name('admin.logout');

Route::group(['middleware' => ['auth:web'],'as'=>'admin.'], function () {
    //home page
    Route::get('home',function(){
        return view('admin.home');
    })->name('home');
    // profile

    Route::get('profile', [ProfileController::class,'updateProfileView'])->name('profile');
    Route::post('profile', [ProfileController::class,'update'])->name('profile.post');
    Route::get('theme', [ProfileController::class,'updateTheme'])->name('theme');

    // users
    Route::resource('users', 'UserController');

    // chat page
    // Route::get('/chat',function () {
    //     // dd(Audit::all());
    //     return view('chat.index');
    // });

});




