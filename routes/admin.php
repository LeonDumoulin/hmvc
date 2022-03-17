<?php

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OwenIt\Auditing\Models\Audit as Audit;
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

Route::group(['middleware' => ['auth:web']], function () {

    //home page
    Route::get('home',function(){
        return view('admin.home');
    })->name('admin.home');
    // profile
    Route::get('profile', 'Auth\ProfileController@updateProfileView')->name('admin.profile');
    Route::post('profile', 'Auth\ProfileController@update')->name('admin.profile.post');
    Route::get('theme', 'Auth\ProfileController@updateTheme')->name('admin.theme');

    // users
    Route::get('users/list', 'UserController@getUsers')->name('admin.users.list');
    Route::resource('users', 'UserController');

    // chat page
    Route::get('/chat',function () {
        // dd(Audit::all());
        return view('admin.chat.index');
    });

});



Route::get('datatable','HomeController@index')->name('admin.datatable');

