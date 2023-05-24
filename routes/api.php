<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\DailyRewardController;
use App\Http\Controllers\API\RewardTypeController;
use App\Http\Controllers\API\LuckyDrawGamesController;
use App\Http\Controllers\API\MissionController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ReferalsStatsController;
use App\Http\Controllers\API\LuckeyWinnerController;
use App\Http\Controllers\API\WithdrawalController;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/passwordChange', [AuthController::class, 'passwordChange']);
    //Route::post('/profile-update',[AuthController::class, 'updateUser']);
    Route::post('/profile-update', [AuthController::class, 'profileUpdate']);
    Route::get('lotter-prize/{id?}', [LuckeyWinnerController::class, 'lotterPrizeWinner']);
    Route::post('user-lotter-prize/claim', [LuckeyWinnerController::class, 'lotterPrizeClaim']);

    Route::get('mission/{id?}', [MissionController::class, 'list']);
    Route::post('mission/submit', [MissionController::class, 'missionSubmit']);
    Route::get('reward-transaction', [RewardTypeController::class, 'rewardTransaction']);
    Route::get('cash-transaction', [WithdrawalController::class, 'cashTransaction']);
    Route::post('cash-withdrawal', [WithdrawalController::class, 'cashWithdrawal']);
    Route::get('withdrawal', [WithdrawalController::class, 'withdrawal']);

    // NOTIFICATION
    Route::get('notification', [NotificationController::class, 'index']);
    Route::get('notification/read-all', [NotificationController::class, 'readAll']);
    Route::get('notification/destroy', [NotificationController::class, 'destroy']);
    Route::get('notification/{id}', [NotificationController::class, 'show']);

    // REFERRAL
    Route::get('referral-count',[AuthController::class,'referral']);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('referal-register/{ref}', 'register');
    Route::post('forgetPassword', 'forgetPassword');
    Route::post('changePassword', 'changePassword');
    Route::get('userwalletap', 'userwalletap');
    Route::get('redeemPoints', 'redeemPoints');
});

Route::controller(RoleController::class)->group(function () {
    Route::get('roles', 'index');
    Route::get('role/{id}', 'show');
});

Route::controller(DailyRewardController::class)->group(function () {
    Route::get('dailyreward', 'index');
    Route::get('dailyreward/{id}', 'show');
    Route::post('', '');
    Route::post('', '');
});

Route::controller(RewardTypeController::class)->group(function () {
    Route::get('rewardtype', 'index');
    Route::get('getrewardtype/{id}', 'show');
    Route::post('', '');
    Route::post('', '');

    // get reward point
    Route::post('dailyRewardPoints', 'dailyRewardPoints');
    Route::post('weeklyRewardPoints', 'weeklyRewardPoints');
});

// Route::post('dailyRewardPoints',[DailyRewardController::class,'dailyRewardPoints']);
// Route::post('weeklyRewardPoints',[DailyRewardController::class,'weeklyRewardPoints']);

Route::controller(LuckyDrawGamesController::class)->group(function () {
    Route::get('allluckydraws', 'index');
    Route::get('luckydraw/{id}', 'show');
    Route::post('', '');
    // Route::post('getNumber' , 'getNumber');
    // Route::get('totalParticipant' , 'totalParticipant');
    // Route::post('userNumber' , 'userNumber');

    Route::post('getNumber', 'getNumber');
    Route::get('totalParticipant', 'totalParticipant');
    Route::get('participantUsername', 'participantUsername');
    Route::post('userNumber', 'userNumber');
});

Route::controller(MissionController::class)->group(function () {
    Route::get('mission', 'index');
    Route::get('mission/{id}', 'show');
    Route::get('', '');
    Route::post('', '');
    Route::post('userMission/{id}', 'userMission');
});

Route::controller(ReferalsStatsController::class)->group(function () {
    Route::get('referalsStats', 'index');
    Route::get('referalsStats/{id}', 'show');
    Route::post('getYourHIstory', 'getYourHIstory');
    Route::post('', '');
    Route::post('', '');
});
