<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;


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

Route::get('/', function () {
    return view('/admin/login');
});



Route::controller(AuthController::class)->group(function(){
    Route::get('/admin', 'index');
    Route::post('/admin/login','login')->name('admin.auth');
    
});

// Group middleware

Route::group(['middleware' => 'admin_auth'], function(){
    Route::get('/admin/dashboard', [AuthController::class,'dashboard']);
    Route::get('/admin/logout',[AuthController::class,'logout'])->name('logout');
});

