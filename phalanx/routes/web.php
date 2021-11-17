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

Route::get('/', [App\Http\Controllers\TopController::class, 'index'])->name('top');

Auth::routes([
    'login' => true,
    'logout' => true,
    'register' => true,
    'reset' => false,
    'confirm' => true,
    'verify' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

// 適性診断 フォーム
Route::get('/aptitude_question_form', [App\Http\Controllers\AptitudeQuestionFormController::class, 'index'])->name('aptitude_question_form.index');
Route::post('/aptitude_question_form', [App\Http\Controllers\AptitudeQuestionFormController::class, 'calculate'])->name('aptitude_question_form.calculate');
Route::get('/aptitude_question_form_apple', [App\Http\Controllers\AptitudeQuestionFormController::class, 'apple'])->name('aptitude_question_form.apple');
Route::get('/aptitude_question_form_mint', [App\Http\Controllers\AptitudeQuestionFormController::class, 'mint'])->name('aptitude_question_form.mint');
Route::get('/aptitude_question_form_maple', [App\Http\Controllers\AptitudeQuestionFormController::class, 'maple'])->name('aptitude_question_form.maple');

// 適性診断 質問管理
Route::get('/aptitude_question_manage/edit_all', [App\Http\Controllers\AptitudeQuestionManageController::class, 'edit_all'])->name('aptitude_question_manage.edit_all');
Route::patch('/aptitude_question_manage/edit_all', [App\Http\Controllers\AptitudeQuestionManageController::class, 'update_all'])->name('aptitude_question_manage.update_all');
Route::resource('/aptitude_question_manage', App\Http\Controllers\AptitudeQuestionManageController::class)->only(['index','edit','update','create','store','destroy']);

// ユーザーマスター
Route::resource('user', App\Http\Controllers\UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

// 事業所マスター
Route::resource('office', App\Http\Controllers\OfficeController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

//ログイン後の画面
Route::get("/user_page", [App\Http\Controllers\UserpageController::class, "index"])->name("user_page");

// チャットルーム
Route::get("/chat_room/list", [App\Http\Controllers\ChatRoomController::class, "list"])->name("chat_room.list");
Route::resource("chat_room", App\Http\Controllers\ChatRoomController::class)->only(["index", "create", "store", "edit", "update", "destroy"]);

// チャット画面
Route::get('/chat/{id}', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/{id}', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');

//////////// API /////////////////////////////////

// ユーザー
Route::POST('/api/v1.0/get/users.json', [App\Http\Controllers\APIController::class, "ApiGetUsers"]);
Route::POST('/api/v1.0/set/users.json', [App\Http\Controllers\APIController::class, "ApiStoreUsers"]);
Route::PUT('/api/v1.0/set/users.json', [App\Http\Controllers\APIController::class, "ApiUpdateUsers"]);
Route::DELETE('/api/v1.0/set/users.json', [App\Http\Controllers\APIController::class, "ApiDeleteUsers"]);
// 事業所
Route::POST('/api/v1.0/get/offices.json', [App\Http\Controllers\APIController::class, "ApiGetOffices"]);

// 予定通知
Route::POST('/api/v1.0/get/notifications.json', [App\Http\Controllers\APIController::class, "ApiGetNotifications"]);
Route::POST('/api/v1.0/set/notifications.json', [App\Http\Controllers\APIController::class, "ApiStoreNotifications"]);
Route::PUT('/api/v1.0/set/notifications.json', [App\Http\Controllers\APIController::class, "ApiUpdateNotifications"]);
Route::DELETE('/api/v1.0/set/notifications.json', [App\Http\Controllers\APIController::class, "ApiDeleteNotifications"]);


//---------- リレーション -----------------------

// 予定通知__ユーザー
Route::POST('/api/v1.0/get/notification__user.json', [App\Http\Controllers\APIController::class, "ApiGetNotificationUser"]);


//URI例。取得系はget、登録系はset。
// /api/v1.0/get/users.json
// /api/v1.0/get/offices.json
// /api/v1.0/set/users.json
