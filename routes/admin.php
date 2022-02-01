<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



