<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

/* Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */

// 通知
Route::resource('/notification', App\Http\Controllers\NotificationController::class);
Route::get('/people_list', [App\Http\Controllers\NotificationController::class, 'pepple_list'])->name('people_list');

// 体験・見学申込管理
Route::get('/trial_application_manage/{id}/check', [App\Http\Controllers\TrialApplicationManageController::class, 'check'])->name('trial_application_manage.check');
Route::patch('/trial_application_manage/{id}/check', [App\Http\Controllers\TrialApplicationManageController::class, 'check_update'])->name('trial_application_manage.check_update');
Route::resource('/trial_application_manage', App\Http\Controllers\TrialApplicationManageController::class)->only(['index','edit','update','destroy']);

// 体験・見学申込フォーム
Route::get('/trial_application_form', [App\Http\Controllers\TrialApplicationFormController::class, 'index'])->name('trial_application_form.index');
Route::post('/trial_application_form', [App\Http\Controllers\TrialApplicationFormController::class, 'store'])->name('trial_application_form.store');
Route::get('/trial_application_form/finish', [App\Http\Controllers\TrialApplicationFormController::class, 'finish'])->name('trial_application_form.finish');

// 適性診断
Route::get('/aptitude_question_form', [App\Http\Controllers\AptitudeQuestionFormController::class, 'index'])->name('aptitude_question_form.index');
Route::post('/aptitude_question_form', [App\Http\Controllers\AptitudeQuestionFormController::class, 'calculate'])->name('aptitude_question_form.calculate');
Route::get('/aptitude_question_form_apple', [App\Http\Controllers\AptitudeQuestionFormController::class, 'apple'])->name('aptitude_question_form.apple');
Route::get('/aptitude_question_form_mint', [App\Http\Controllers\AptitudeQuestionFormController::class, 'mint'])->name('aptitude_question_form.mint');
Route::get('/aptitude_question_form_maple', [App\Http\Controllers\AptitudeQuestionFormController::class, 'maple'])->name('aptitude_question_form.maple');
Route::resource('/aptitude_question_manage', App\Http\Controllers\AptitudeQuestionManageController::class)->only(['index','create','store','edit','update','destroy']);

// ユーザーマスター
Route::resource('user', App\Http\Controllers\UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

// 事業所マスター
Route::resource('office', App\Http\Controllers\OfficeController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

//ログイン後の利用者の画面（仮）
Route::get("/user_page", [App\Http\Controllers\UserpageController::class, "index"])->name("user_page");

// チャットルーム
Route::get("/chat_room/list", [App\Http\Controllers\ChatRoomController::class, "list"])->name("chat_room.list");
Route::resource("chat_room", App\Http\Controllers\ChatRoomController::class);



//////////// API /////////////////////////////////
// ユーザー
Route::POST('/api/v1.0/get/users', [App\Http\Controllers\APIController::class, "ApiGetUsers"]);
// 事業所
Route::POST('/api/v1.0/get/offices', [App\Http\Controllers\APIController::class, "ApiGetOffices"]);

// 予定通知
Route::POST('/api/v1.0/get/notifications', [App\Http\Controllers\APIController::class, "ApiGetNotifications"]);
Route::POST('/api/v1.0/set/notifications', [App\Http\Controllers\APIController::class, "ApiStoreNotifications"]);
Route::PUT('/api/v1.0/set/notifications', [App\Http\Controllers\APIController::class, "ApiUpdateNotifications"]);
Route::DELETE('/api/v1.0/set/notifications', [App\Http\Controllers\APIController::class, "ApiDeleteNotifications"]);

//URI例。取得系はget、登録系はset。
// /api/v1.0/get/users
// /api/v1.0/get/offices
// /api/v1.0/set/users
