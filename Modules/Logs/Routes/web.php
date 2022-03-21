<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Logs\Http\Controllers\LogsController;

Route::group(['middleware' => ['auth:web']], function () {
    Route::get('logs',[LogsController::class,'index'])->name('admin.logs');
});
