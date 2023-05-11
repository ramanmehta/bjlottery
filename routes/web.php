<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\DailyRewardController;
use App\Http\Controllers\admin\RewardTypeController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\LuckyDrawGamesController;
// use App\Http\Controllers\admin\MissionController;
use App\Http\Controllers\admin\MissionsController;
use App\Http\Controllers\admin\NotificationController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ReferalsStatsController;
use App\Http\Controllers\admin\MissionLevelController;
use App\Http\Controllers\admin\MissionSubmissionController;
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


Route::get('/webapp/login',function(){
    return view('webapp.login');
});
Route::get('/webapp/register',function(){
    return view('webapp.register');
});

// Route::get('/webapp/registration',function(){
//     return view('webapp.registration');
// });

Route::controller(AuthController::class)->group(function(){
    Route::get('/admin', 'index');
    Route::post('/admin/login','login')->name('admin.auth');
    
});


// Group middleware

Route::group(['middleware' => 'admin_auth'], function(){
    Route::get('/admin/dashboard', [AuthController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',[AuthController::class,'logout'])->name('admin.logout');

    // roles route
    Route::get('/admin/viewRoles', [RoleController::class,'index'])->name('viewRoles');
    Route::get('/admin/createRoles', [RoleController::class,'create'])->name('createRoles');
    Route::post('/admin/createRoles', [RoleController::class,'store'])->name('user.role');
    Route::get('/admin/editRoles/{id}', [RoleController::class,'edit'])->name('editRole');
    Route::post('/admin/updateRoles/{id}', [RoleController::class,'update'])->name('update.role');
    Route::get('/admin/deleteRoles/{id}', [RoleController::class,'destroy'])->name('removeRole');

    // rewards  route

    // Route::get('/admin/viewDailyRewards', [DailyRewardController::class,'index'])->name('DailyRewards');
    // Route::get('/admin/createDailyRewards', [DailyRewardController::class,'create'])->name('createDailyRewards');
    // Route::post('/admin/createDailyRewards', [DailyRewardController::class,'store'])->name('user.DailyReward');
    // Route::get('/admin/editDailyReward/{id}', [DailyRewardController::class,'edit'])->name('editDailyReward');
    // Route::post('/admin/updateDailyReward/{id}', [DailyRewardController::class,'update'])->name('update.DailyReward');
    // Route::get('/admin/deleteDailyReward/{id}', [DailyRewardController::class,'destroy'])->name('removeDailyReward');

    Route::get('/admin/viewRewardType', [RewardTypeController::class,'index'])->name('RewardType');
    Route::get('/admin/createRewardType', [RewardTypeController::class,'create'])->name('createRewardType');
    Route::post('/admin/createRewardType', [RewardTypeController::class,'store'])->name('create.RewardType');
    Route::get('/admin/editRewardType/{id}', [RewardTypeController::class,'edit'])->name('editRewardType');
    Route::post('/admin/updateRewardType/{id}', [RewardTypeController::class,'update'])->name('update.RewardType');
    Route::get('/admin/deleteRewardType/{id}', [RewardTypeController::class,'destroy'])->name('removeRewardType');
    Route::get('/admin/rewardStatus/{id}', [RewardTypeController::class,'rewardStatus'])->name('rewardStatus');

    // register user detail route


    Route::get('/admin/viewUser', [UsersController::class,'index'])->name('admin.users');
    // Route::get('/admin/viewUser', [UsersController::class,'index'])->name('admin.users');
    // Route::get('/admin/createUser', [UsersController::class,'create']);
    // Route::post('/admin/createUser', [UsersController::class,'store'])->name('user.DailyReward');
    Route::get('/admin/editUser/{id}', [UsersController::class,'edit'])->name('edituser');
    Route::post('/admin/updateUser/{id}', [UsersController::class,'update'])->name('update.User');
    Route::get('/admin/deleteUser/{id}', [UsersController::class,'destroy'])->name('removeUser');
    Route::get('/admin/userStatus/{id}', [UsersController::class,'userStatus'])->name('userStatus');
    Route::get('/admin/userAppoint/{id}', [UsersController::class,'userAppoint'])->name('userAppoint');
    Route::post('/admin/updateAppoint/{id}', [UsersController::class,'updateAppoint'])->name('updateAppoint');
    Route::get('/admin/editWallet/{id}', [UsersController::class,'editWallet'])->name('editWallet');
    Route::post('/admin/updateWallet/{id}', [UsersController::class,'updateWallet'])->name('updateWallet');
    Route::get('/admin/cPassword/{id}', [UsersController::class,'changePassword'])->name('cPassword');
    Route::post('/admin/passwordReset/{id}', [UsersController::class,'passwordReset'])->name('passwordReset');

    // Route::controller(UsersController::class)->group(function(){
    //     Route::get('/admin/userStatus/{id}', 'userStatus')->name('userStatus');
    // });

    // lucky_draw_games route

    Route::get('/admin/viewLuckyDraw', [LuckyDrawGamesController::class,'index'])->name('luckyDraw');
    Route::get('/admin/createLuckyDraw', [LuckyDrawGamesController::class,'create'])->name('createLuckyDraw');
    Route::post('/admin/createLuckyDraw', [LuckyDrawGamesController::class,'store'])->name('user.LuckyDraw');
    Route::get('/admin/editLuckyDraw/{id}', [LuckyDrawGamesController::class,'edit'])->name('editLuckyDraw');
    Route::post('/admin/updateLuckyDraw/{id}', [LuckyDrawGamesController::class,'update'])->name('update.LuckyDraw');
    Route::get('/admin/deleteLuckyDraw/{id}', [LuckyDrawGamesController::class,'destroy'])->name('removeLuckyDraw');
    Route::get('/admin/luckyDrawsStatus/{id}', [LuckyDrawGamesController::class,'lotteryStatus'])->name('luckyDrawsStatus');

    Route::get('admin/add-price/{id}', [LuckyDrawGamesController::class,'luckyWinnerList'])->name('add.price');
    Route::get('admin/add-price-form/{id}', [LuckyDrawGamesController::class,'addPrice'])->name('add.price.form');
    Route::post('admin/add-price', [LuckyDrawGamesController::class,'addPriceStore'])->name('add.price.post');
    Route::get('admin/add-price/edit/{id}', [LuckyDrawGamesController::class,'addPriceEdit'])->name('add.price.edit');
    Route::get('admin/add-price/destroy/{lottery_id}/{id}', [LuckyDrawGamesController::class,'addPriceDestroy'])->name('add.price.destroy');
    Route::get('admin/winner-user/claim',[LuckyDrawGamesController::class,'winnerUserClaim'])->name('winner.user.claim');
    Route::post('admin/edit-prize/update/{id}',[LuckyDrawGamesController::class,'editPrizeUpdate'])->name('edit.prize.update');

    
    // Missions route
    Route::get('/admin/viewMission', [MissionsController::class,'index'])->name('mission');
    Route::get('/admin/createMission', [MissionsController::class,'create'])->name('createMission');
    Route::post('/admin/createMission', [MissionsController::class,'store'])->name('user.Mission');
    Route::get('/admin/editMission/{id}', [MissionsController::class,'edit'])->name('editMission');
    Route::post('/admin/updateMission/{id}', [MissionsController::class,'update'])->name('update.Mission');
    Route::get('/admin/deleteMission/{id}', [MissionsController::class,'destroy'])->name('removeMission');
    Route::get('/admin/missionStatus/{id}', [MissionsController::class,'missionStatus'])->name('missionStatus');

     // levels route    
    Route::get('/admin/levels/{id}', [MissionLevelController::class,'index'])->name('levels');

    Route::get('/admin/createLevels', [MissionLevelController::class,'create'])->name('createlevels');    
    Route::post('/admin/createLevels', [MissionLevelController::class,'store'])->name('createlevels.store');
    Route::get('/admin/deleteLevelMission/{id}/{mission_id}', [MissionLevelController::class,'destroy'])->name('removeLevelMission');
    Route::get('/admin/editMissionLevel/{id}', [MissionLevelController::class,'edit'])->name('editMissionLevel');
    Route::post('/admin/updateMissionLevel/{id}', [MissionLevelController::class,'update'])->name('editMissionLevel.id');  
    
    // Mission Submissions 
    
    Route::get('/admin/mission-submissions', [MissionSubmissionController::class,'index'])->name('mission-submissions.index');   
    // Settings route

    Route::get('/admin/viewSetting', [SettingController::class,'index'])->name('settings');
    Route::get('/admin/createSetting', [SettingController::class,'create'])->name('createSetting');
    Route::post('/admin/createSetting', [SettingController::class,'store'])->name('adminSetting');
    Route::get('/admin/editSetting/{id}', [SettingController::class,'edit'])->name('editSetting');
    Route::post('/admin/updateSetting/{id}', [SettingController::class,'update'])->name('update.Setting');
    Route::get('/admin/deleteSetting/{id}', [SettingController::class,'destroy'])->name('removeSetting');

     // Notifications route

    Route::get('/admin/viewNotifications', [NotificationController::class,'index'])->name('notifications');
    Route::get('/admin/createNotifications', [NotificationController::class,'create'])->name('createNotifications');
    Route::post('/admin/createNotifications', [NotificationController::class,'store'])->name('user.Notifications');
    Route::get('/admin/editNotifications/{id}', [NotificationController::class,'edit'])->name('editNotifications');
    Route::post('/admin/updateNotifications/{id}', [NotificationController::class,'update'])->name('update.Notifications');
    Route::get('/admin/deleteNotifications/{id}', [NotificationController::class,'destroy'])->name('removeNotifications');

    // Referal status 

    Route::get('/admin/viewReferalstatus', [ReferalsStatsController::class,'index'])->name('referalstatus');
    Route::get('/admin/createReferalstatus', [ReferalsStatsController::class,'create'])->name('createReferalstatus');
    Route::post('/admin/createReferalstatus', [ReferalsStatsController::class,'store'])->name('user.Referalstatus');
    Route::get('/admin/editReferalstatus/{id}', [ReferalsStatsController::class,'edit'])->name('editReferalstatus');
    Route::post('/admin/updateReferalstatus/{id}', [ReferalsStatsController::class,'update'])->name('update.Referalstatus');
    Route::get('/admin/deleteReferalstatus/{id}', [ReferalsStatsController::class,'destroy'])->name('removeReferalstatus');
});

// test relationship
Route::get('/fortest/join', [\App\Http\Controllers\fortest\JoinController::class,'referalPoints']);
Route::get('/fortest/date', [\App\Http\Controllers\fortest\JoinController::class,'datetimeOnly']);

Route::post('status/update/winner/user',[LuckyDrawGamesController::class,'statusUpdateWinnerUser'])->name('status.update.winner.user');