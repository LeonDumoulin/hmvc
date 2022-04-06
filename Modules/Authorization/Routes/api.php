<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Authorization\Http\Controllers\Api\MainController;

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

Route::get('roles', [MainController::class,'index'])->name('admin.roles.datatable');
