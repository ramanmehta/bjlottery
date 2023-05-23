<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RewardTypesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\LuckyDrawGamesController;
use App\Http\Controllers\Admin\MissionsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReferalsStatsController;
use App\Http\Controllers\Admin\MissionLevelController;
use App\Http\Controllers\Admin\MissionSubmissionController;
use App\Http\Controllers\Admin\WithdrawalController;

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
    return view('admin/login');
});
Route::get('webapp/login', function () {
    return view('webapp.login');
});
Route::get('webapp/register', function () {
    return view('webapp.register');
});
Route::get('webapp/registration', function () {
    return view('webapp.registration');
});

Route::get('admin', [AuthController::class, 'index']);
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.auth');

Route::group(['middleware' => 'admin_auth', 'prefix' => 'admin'], function () {

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    // ROLES ROUTE
    Route::get('viewRoles', [RoleController::class, 'index'])->name('viewRoles');
    Route::get('createRoles', [RoleController::class, 'create'])->name('createRoles');
    Route::post('createRoles', [RoleController::class, 'store'])->name('user.role');
    Route::get('editRoles/{id}', [RoleController::class, 'edit'])->name('editRole');
    Route::post('updateRoles/{id}', [RoleController::class, 'update'])->name('update.role');
    Route::get('deleteRoles/{id}', [RoleController::class, 'destroy'])->name('removeRole');

    // REWARDS  ROUTE
    // Route::get('viewDailyRewards', [DailyRewardController::class,'index'])->name('DailyRewards');
    // Route::get('createDailyRewards', [DailyRewardController::class,'create'])->name('createDailyRewards');
    // Route::post('createDailyRewards', [DailyRewardController::class,'store'])->name('user.DailyReward');
    // Route::get('editDailyReward/{id}', [DailyRewardController::class,'edit'])->name('editDailyReward');
    // Route::post('updateDailyReward/{id}', [DailyRewardController::class,'update'])->name('update.DailyReward');
    // Route::get('deleteDailyReward/{id}', [DailyRewardController::class,'destroy'])->name('removeDailyReward');

    Route::get('viewRewardType', [RewardTypesController::class, 'index'])->name('RewardType');
    Route::get('createRewardType', [RewardTypesController::class, 'create'])->name('createRewardType');
    Route::post('createRewardType', [RewardTypesController::class, 'store'])->name('create.RewardType');
    Route::get('editRewardType/{id}', [RewardTypesController::class, 'edit'])->name('editRewardType');
    Route::post('updateRewardType/{id}', [RewardTypesController::class, 'update'])->name('update.RewardType');
    Route::get('deleteRewardType/{id}', [RewardTypesController::class, 'destroy'])->name('removeRewardType');
    Route::get('rewardStatus/{id}', [RewardTypesController::class, 'rewardStatus'])->name('rewardStatus');

    // REGISTER USER DETAIL ROUTE
    Route::get('viewUser', [UsersController::class, 'index'])->name('admin.users');
    // Route::get('viewUser', [UsersController::class,'index'])->name('admin.users');
    // Route::get('createUser', [UsersController::class,'create']);
    // Route::post('createUser', [UsersController::class,'store'])->name('user.DailyReward');
    Route::get('editUser/{id}', [UsersController::class, 'edit'])->name('edituser');
    Route::post('updateUser/{id}', [UsersController::class, 'update'])->name('update.User');
    Route::get('deleteUser/{id}', [UsersController::class, 'destroy'])->name('removeUser');
    Route::get('userStatus/{id}', [UsersController::class, 'userStatus'])->name('userStatus');
    Route::get('userAppoint/{id}', [UsersController::class, 'userAppoint'])->name('userAppoint');
    Route::post('updateAppoint/{id}', [UsersController::class, 'updateAppoint'])->name('updateAppoint');
    Route::get('editWallet/{id}', [UsersController::class, 'editWallet'])->name('editWallet');
    Route::post('updateWallet/{id}', [UsersController::class, 'updateWallet'])->name('updateWallet');
    Route::get('cPassword/{id}', [UsersController::class, 'changePassword'])->name('cPassword');
    Route::post('passwordReset/{id}', [UsersController::class, 'passwordReset'])->name('passwordReset');

    // LUCKY DRAW GAMES ROUTE
    Route::get('viewLuckyDraw', [LuckyDrawGamesController::class, 'index'])->name('luckyDraw');
    Route::get('createLuckyDraw', [LuckyDrawGamesController::class, 'create'])->name('createLuckyDraw');
    Route::post('createLuckyDraw', [LuckyDrawGamesController::class, 'store'])->name('user.LuckyDraw');
    Route::get('editLuckyDraw/{id}', [LuckyDrawGamesController::class, 'edit'])->name('editLuckyDraw');
    Route::post('updateLuckyDraw/{id}', [LuckyDrawGamesController::class, 'update'])->name('update.LuckyDraw');
    Route::get('deleteLuckyDraw/{id}', [LuckyDrawGamesController::class, 'destroy'])->name('removeLuckyDraw');
    Route::get('luckyDrawsStatus/{id}', [LuckyDrawGamesController::class, 'lotteryStatus'])->name('luckyDrawsStatus');

    Route::get('add-price/{id}', [LuckyDrawGamesController::class, 'luckyWinnerList'])->name('add.price');
    Route::get('add-price-form/{id}', [LuckyDrawGamesController::class, 'addPrice'])->name('add.price.form');
    Route::post('add-price', [LuckyDrawGamesController::class, 'addPriceStore'])->name('add.price.post');
    Route::get('add-price/edit/{id}', [LuckyDrawGamesController::class, 'addPriceEdit'])->name('add.price.edit');
    Route::get('add-price/destroy/{lottery_id}/{id}', [LuckyDrawGamesController::class, 'addPriceDestroy'])->name('add.price.destroy');
    Route::get('winner-user/claim', [LuckyDrawGamesController::class, 'winnerUserClaim'])->name('winner.user.claim');
    Route::post('edit-prize/update/{id}', [LuckyDrawGamesController::class, 'editPrizeUpdate'])->name('edit.prize.update');

    // MISSIONS ROUTE
    Route::get('viewMission', [MissionsController::class, 'index'])->name('mission');
    Route::get('createMission', [MissionsController::class, 'create'])->name('createMission');
    Route::post('createMission', [MissionsController::class, 'store'])->name('user.Mission');
    Route::get('editMission/{id}', [MissionsController::class, 'edit'])->name('editMission');
    Route::post('updateMission/{id}', [MissionsController::class, 'update'])->name('update.Mission');
    Route::get('deleteMission/{id}', [MissionsController::class, 'destroy'])->name('removeMission');
    Route::get('missionStatus/{id}', [MissionsController::class, 'missionStatus'])->name('missionStatus');

    // LEVELS ROUTE
    Route::get('levels/{id}', [MissionLevelController::class, 'index'])->name('levels');
    Route::get('createLevels', [MissionLevelController::class, 'create'])->name('createlevels');
    Route::post('createLevels', [MissionLevelController::class, 'store'])->name('createlevels.store');
    Route::get('deleteLevelMission/{id}/{mission_id}', [MissionLevelController::class, 'destroy'])->name('removeLevelMission');
    Route::get('editMissionLevel/{id}', [MissionLevelController::class, 'edit'])->name('editMissionLevel');
    Route::post('updateMissionLevel/{id}', [MissionLevelController::class, 'update'])->name('editMissionLevel.id');

    // MISSION SUBMISSIONS 
    Route::get('mission-submissions/{id?}', [MissionSubmissionController::class, 'index'])->name('mission-submissions.index');
    Route::get('mission-submissions-show/{id}', [MissionSubmissionController::class, 'show'])->name('missionsubmissions.show');

    // SETTINGS ROUTE
    Route::get('viewSetting', [SettingController::class, 'index'])->name('settings');
    Route::get('createSetting', [SettingController::class, 'create'])->name('createSetting');
    Route::post('createSetting', [SettingController::class, 'store'])->name('adminSetting');
    Route::get('editSetting/{id}', [SettingController::class, 'edit'])->name('editSetting');
    Route::post('updateSetting/{id}', [SettingController::class, 'update'])->name('update.Setting');
    Route::get('deleteSetting/{id}', [SettingController::class, 'destroy'])->name('removeSetting');

    // NOTIFICATIONS ROUTE
    Route::get('viewNotifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('createNotifications', [NotificationController::class, 'create'])->name('createNotifications');
    Route::post('createNotifications', [NotificationController::class, 'store'])->name('user.Notifications');
    Route::get('editNotifications/{id}', [NotificationController::class, 'edit'])->name('editNotifications');
    Route::post('updateNotifications/{id}', [NotificationController::class, 'update'])->name('update.Notifications');
    Route::get('deleteNotifications/{id}', [NotificationController::class, 'destroy'])->name('removeNotifications');

    // REFERAL STATUS 
    Route::get('viewReferalstatus', [ReferalsStatsController::class, 'index'])->name('referalstatus');
    Route::get('createReferalstatus', [ReferalsStatsController::class, 'create'])->name('createReferalstatus');
    Route::post('createReferalstatus', [ReferalsStatsController::class, 'store'])->name('user.Referalstatus');
    Route::get('editReferalstatus/{id}', [ReferalsStatsController::class, 'edit'])->name('editReferalstatus');
    Route::post('updateReferalstatus/{id}', [ReferalsStatsController::class, 'update'])->name('update.Referalstatus');
    Route::get('deleteReferalstatus/{id}', [ReferalsStatsController::class, 'destroy'])->name('removeReferalstatus');

    Route::get('withdraw', [WithdrawalController::class, 'withdraw'])->name('withdraw');
});

Route::post('status/update/winner/user', [LuckyDrawGamesController::class, 'statusUpdateWinnerUser'])->name('status.update.winner.user');
Route::post('mission/submit/status/update', [LuckyDrawGamesController::class, 'missionSubmitStatusUpdate'])->name('mission.submit.status.update');
Route::post('withdrawal-status', [WithdrawalController::class, 'withdrawalStatus'])->name('withdrawal.status');
