<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\DailyRewardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\LuckyDrawGamesController;
use App\Http\Controllers\admin\MissionController; 

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

    // roles route
    Route::get('/admin/viewRoles', [RoleController::class,'index'])->name('viewRoles');
    Route::get('/admin/createRoles', [RoleController::class,'create']);
    Route::post('/admin/createRoles', [RoleController::class,'store'])->name('user.role');
    Route::get('/admin/editRoles/{id}', [RoleController::class,'edit']);
    Route::post('/admin/updateRoles/{id}', [RoleController::class,'update'])->name('update.role');
    Route::get('/admin/deleteRoles/{id}', [RoleController::class,'destroy']);

    // daily_rewards  route

    Route::get('/admin/viewDailyRewards', [DailyRewardController::class,'index']);
    Route::get('/admin/createDailyRewards', [DailyRewardController::class,'create']);
    Route::post('/admin/createDailyRewards', [DailyRewardController::class,'store'])->name('user.DailyReward');
    Route::get('/admin/editDailyReward/{id}', [DailyRewardController::class,'edit']);
    Route::post('/admin/updateDailyReward/{id}', [DailyRewardController::class,'update'])->name('update.DailyReward');
    Route::get('/admin/deleteDailyReward/{id}', [DailyRewardController::class,'destroy']);

    // register user detail route

    Route::get('/admin/viewUser', [UserController::class,'index']);
    // Route::get('/admin/createUser', [UserController::class,'create']);
    // Route::post('/admin/createUser', [UserController::class,'store'])->name('user.DailyReward');
    Route::get('/admin/editUser/{id}', [UserController::class,'edit']);
    Route::post('/admin/updateUser/{id}', [UserController::class,'update'])->name('update.User');
    Route::get('/admin/deleteUser/{id}', [UserController::class,'destroy']);

    // lucky_draw_games route

    Route::get('/admin/viewLuckyDraw', [LuckyDrawGamesController::class,'index']);
    Route::get('/admin/createLuckyDraw', [LuckyDrawGamesController::class,'create']);
    Route::post('/admin/createLuckyDraw', [LuckyDrawGamesController::class,'store'])->name('user.LuckyDraw');
    Route::get('/admin/editLuckyDraw/{id}', [LuckyDrawGamesController::class,'edit']);
    Route::post('/admin/updateLuckyDraw/{id}', [LuckyDrawGamesController::class,'update'])->name('update.LuckyDraw');
    Route::get('/admin/deleteLuckyDraw/{id}', [LuckyDrawGamesController::class,'destroy']);

    // Missions route

    Route::get('/admin/viewMission', [MissionController::class,'index']);
    Route::get('/admin/createMission', [MissionController::class,'create']);
    Route::post('/admin/createMission', [MissionController::class,'store'])->name('user.Mission');
    Route::get('/admin/editMission/{id}', [MissionController::class,'edit']);
    Route::post('/admin/updateMission/{id}', [MissionController::class,'update'])->name('update.Mission');
    Route::get('/admin/deleteMission/{id}', [MissionController::class,'destroy']);

});

