<?php


use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\FollowUpPagesController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\LiveController;
use App\Http\Controllers\Api\LiveFacebookController;
use App\Http\Controllers\Api\LiveInstagramController;
use App\Http\Controllers\Api\LiveLinkedinController;
use App\Http\Controllers\Api\LiveTwitterController;
use App\Http\Controllers\Api\LiveYoutubeController;
use App\Http\Controllers\Api\MagazineController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PerformanceController;
use App\Http\Controllers\Api\RecentAchievementController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TopNotificationController;
use App\Http\Controllers\Api\TrainningVideoController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['api', 'isAdmin']], function () {

    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('isAdmin');
    Route::post('register', [AuthController::class, 'register'])->withoutMiddleware('isAdmin');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('allusers', [AuthController::class, 'allusers'])->middleware('RoleIsAdmin');
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('usersProfile', [AuthController::class, 'usersProfile']);
    Route::get('userProfileById', [AuthController::class, 'userProfilebyid']);
    Route::post('update_user', [AuthController::class, 'update'])->middleware('RoleIsAdmin');
    Route::delete('delete', [AuthController::class, 'destroy']);
    Route::post('updateProfile', [AuthController::class, 'updateProfile']);
    Route::post('password/email', [ForgotPasswordController::class, 'forgetPassword'])->withoutMiddleware('isAdmin');
    Route::post('password/reset', [ForgotPasswordController::class, 'resetPassword'])->withoutMiddleware('isAdmin');
    Route::get('show/notification', [AuthController::class, 'showNotification']);
    Route::get('read/notification', [AuthController::class, 'readNotification']);
    Route::get('country', [CountryController::class, 'index'])->withoutMiddleware('isAdmin');

    Route::group(['prefix' => 'team'], function () {
        Route::get('show_all', [TeamController::class, 'index']);
        Route::post('save', [TeamController::class, 'store']);
        Route::post('show/{id}', [TeamController::class, 'show']);
        Route::post('update/{id}', [TeamController::class, 'update']);
        Route::post('delete/{id}', [TeamController::class, 'destroy']);
    });

    Route::group(['prefix' => 'magazine'], function () {
        Route::get('show_all', [MagazineController::class, 'index']);
        Route::post('save', [MagazineController::class, 'store']);
        Route::post('show/{id}', [MagazineController::class, 'show']);
        Route::post('update/{id}', [MagazineController::class, 'update']);
        Route::post('delete/{id}', [MagazineController::class, 'destroy']);
    });

    Route::group(['prefix' => 'faq'], function () {
        Route::get('show_all', [FaqController::class, 'index']);
        Route::post('save', [FaqController::class, 'store']);
        Route::post('show/{id}', [FaqController::class, 'show']);
        Route::post('update/{id}', [FaqController::class, 'update']);
        Route::post('delete/{id}', [FaqController::class, 'destroy']);
    });

    Route::group(['prefix' => 'performance'], function () {
        Route::get('show_all', [PerformanceController::class, 'index']);
        Route::post('save', [PerformanceController::class, 'store']);
        Route::post('show/{id}', [PerformanceController::class, 'show']);
        Route::post('update/{id}', [PerformanceController::class, 'update']);
        Route::post('delete/{id}', [PerformanceController::class, 'destroy']);
    });

    Route::group(['prefix' => 'advertisement'], function () {
        Route::get('show_all', [AdvertisementController::class, 'index']);
        Route::post('save', [AdvertisementController::class, 'store']);
        Route::post('show/{id}', [AdvertisementController::class, 'show']);
        Route::post('update/{id}', [AdvertisementController::class, 'update']);
        Route::post('delete/{id}', [AdvertisementController::class, 'destroy']);
    });

    Route::group(['prefix' => 'live'], function () {
        Route::get('show_all', [LiveController::class, 'index']);
        Route::post('save', [LiveController::class, 'store']);
        Route::post('show/{id}', [LiveController::class, 'show']);
        Route::post('update/{id}', [LiveController::class, 'update']);
        Route::post('delete/{id}', [LiveController::class, 'destroy']);
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('show_all', [NotificationController::class, 'index']);
        Route::post('save', [NotificationController::class, 'store']);
        Route::post('show/{id}', [NotificationController::class, 'show']);
        Route::post('update/{id}', [NotificationController::class, 'update']);
        Route::post('delete/{id}', [NotificationController::class, 'destroy']);
    });

    Route::group(['prefix' => 'plan'], function () {
        Route::get('show_all', [SubscriptionController::class, 'showPlans']);
        Route::post('savePlan', [SubscriptionController::class, 'savePlan'])->middleware('RoleIsAdmin');
        Route::post('checkoutPlan', [SubscriptionController::class, 'checkout']);
        Route::get('allSubscriptions', [SubscriptionController::class, 'allSubscriptions'])->middleware('RoleIsAdmin');
        Route::post('showUser', [SubscriptionController::class, 'showUser']);
    });

    Route::group(['prefix' => 'top_notification'], function () {
        Route::get('show_all', [TopNotificationController::class, 'index']);
        Route::post('save', [TopNotificationController::class, 'store']);
        Route::post('show/{id}', [TopNotificationController::class, 'show']);
        Route::post('update/{id}', [TopNotificationController::class, 'update']);
        Route::post('delete/{id}', [TopNotificationController::class, 'destroy']);
    });

    Route::group(['prefix' => 'recentachievement'], function () {
        Route::get('show_all', [RecentAchievementController::class, 'index']);
        Route::post('save', [RecentAchievementController::class, 'store']);
        Route::post('show/{id}', [RecentAchievementController::class, 'show']);
        Route::post('update/{id}', [RecentAchievementController::class, 'update']);
        Route::post('delete/{id}', [RecentAchievementController::class, 'destroy']);
    });

    Route::group(['prefix' => 'feature'], function () {
        Route::get('show_all', [FeatureController::class, 'index']);
        Route::post('save', [FeatureController::class, 'store']);
        Route::post('show/{id}', [FeatureController::class, 'show']);
        Route::post('update/{id}', [FeatureController::class, 'update']);
        Route::post('delete/{id}', [FeatureController::class, 'destroy']);
    });

    Route::group(['prefix' => 'FollowUpPages'], function () {
        Route::get('show_all', [FollowUpPagesController::class, 'index']);
        Route::post('save', [FollowUpPagesController::class, 'store']);
        Route::post('show/{id}', [FollowUpPagesController::class, 'show']);
        Route::post('update/{id}', [FollowUpPagesController::class, 'update']);
        Route::post('delete/{id}', [FollowUpPagesController::class, 'destroy']);
    });

    Route::group(['prefix' => 'training_video'], function () {
        Route::get('show_all', [TrainningVideoController::class, 'index']);
        Route::post('save', [TrainningVideoController::class, 'store']);
        Route::post('show/{id}', [TrainningVideoController::class, 'show']);
        Route::post('update/{id}', [TrainningVideoController::class, 'update']);
        Route::post('delete/{id}', [TrainningVideoController::class, 'destroy']);
    });

    Route::group(['prefix' => 'livefacebook'], function () {
        Route::get('show_all', [LiveFaceBookController::class, 'index']);
        Route::post('save', [LiveFaceBookController::class, 'store']);
        Route::post('show/{id}', [LiveFaceBookController::class, 'show']);
        Route::post('update/{id}', [LiveFaceBookController::class, 'update']);
        Route::post('delete/{id}', [LiveFaceBookController::class, 'destroy']);
    });

    Route::group(['prefix' => 'livetwitter'], function () {
        Route::get('show_all', [LiveTwitterController::class, 'index']);
        Route::post('save', [LiveTwitterController::class, 'store']);
        Route::post('show/{id}', [LiveTwitterController::class, 'show']);
        Route::post('update/{id}', [LiveTwitterController::class, 'update']);
        Route::post('delete/{id}', [LiveTwitterController::class, 'destroy']);
    });

    Route::group(['prefix' => 'liveyoutube'], function () {
        Route::get('show_all', [LiveYoutubeController::class, 'index']);
        Route::post('save', [LiveYoutubeController::class, 'store']);
        Route::post('show/{id}', [LiveYoutubeController::class, 'show']);
        Route::post('update/{id}', [LiveYoutubeController::class, 'update']);
        Route::post('delete/{id}', [LiveYoutubeController::class, 'destroy']);
    });

    Route::group(['prefix' => 'liveinstagram'], function () {
        Route::get('show_all', [LiveInstagramController::class, 'index']);
        Route::post('save', [LiveInstagramController::class, 'store']);
        Route::post('show/{id}', [LiveInstagramController::class, 'show']);
        Route::post('update/{id}', [LiveInstagramController::class, 'update']);
        Route::post('delete/{id}', [LiveInstagramController::class, 'destroy']);
    });

    Route::group(['prefix' => 'livelinkedin'], function () {
        Route::get('show_all', [LiveLinkedinController::class, 'index']);
        Route::post('save', [LiveLinkedinController::class, 'store']);
        Route::post('show/{id}', [LiveLinkedinController::class, 'show']);
        Route::post('update/{id}', [LiveLinkedinController::class, 'update']);
        Route::post('delete/{id}', [LiveLinkedinController::class, 'destroy']);
    });

});

