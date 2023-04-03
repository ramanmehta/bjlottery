<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\DailyRewardController;
use App\Http\Controllers\API\LuckyDrawGamesController;
use App\Http\Controllers\API\MissionController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ReferalsStatsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->post('/passwordChange', [AuthController::class, 'passwordChange']);

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
    Route::post('referal-register/{ref}','register');
    Route::post('forgetPassword','forgetPassword');
    Route::post('changePassword','changePassword');
});



Route::controller(RoleController::class)->group(function(){
    
    Route::get('roles','index');
    Route::get('role/{id}','show');
});

Route::controller(DailyRewardController::class)->group(function(){
    Route::get('dailyreward' , 'index');
    Route::get('dailyreward/{id}' , 'show');
    Route::post('' , '');
    Route::post('' , '');
});

Route::post('dailyRewardPoints',[DailyRewardController::class,'dailyRewardPoints']);
Route::post('weeklyRewardPoints',[DailyRewardController::class,'weeklyRewardPoints']);

Route::controller(LuckyDrawGamesController::class)->group(function(){
    Route::get('luckydraw' , 'index');
    Route::get('luckydraw/{id}' , 'show');
    Route::post('' , '');
    Route::post('' , '');
});

Route::controller(MissionController::class)->group(function(){
    Route::get('mission' , 'index');
    Route::get('mission/{id}' , 'show');
    Route::get('' , '');
    Route::post('' , '');
    Route::post('' , '');
});

Route::controller(NotificationController::class)->group(function(){
    Route::get('notification' , 'index');
    Route::get('notification/{id}' , 'show');
    Route::post('' , '');
    Route::get('' , '');
});


Route::controller(ReferalsStatsController::class)->group(function(){
    Route::get('referalsStats' , 'index');
    Route::get('referalsStats/{id}' , 'show');
    Route::get('' , '');
    Route::post('' , '');
    Route::post('' , '');
    

});


