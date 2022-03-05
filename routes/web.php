<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return 'done';
});

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
});

Route::get('/', function () {
    // \App\User::create([
    //     'name' => 'admin',
    //     'email' =>'admin@admin.com',
    //     'password' => bcrypt(123),
    //     'email_verified_at' => Carbon\Carbon::now(),

    // ]);
    return view('welcome');
});






// Route::get('/home',function () {
//     return view('admin.dashboard');
// })->name('admin.dashboard');

// Route::get('telegram', '\App\Notification\TelegramBot@buildRequestUrl');
