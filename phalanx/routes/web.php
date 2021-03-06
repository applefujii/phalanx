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

// 通知
Route::resource('/notification', App\Http\Controllers\NotificationController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

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
Route::get('/aptitude_question_form/{max_office_id}/result', [App\Http\Controllers\AptitudeQuestionFormController::class, 'result'])->name('aptitude_question_form.result');

// 適性診断 質問管理
Route::get('/aptitude_question_manage/edit_all', [App\Http\Controllers\AptitudeQuestionManageController::class, 'edit_all'])->name('aptitude_question_manage.edit_all');
Route::patch('/aptitude_question_manage/edit_all', [App\Http\Controllers\AptitudeQuestionManageController::class, 'update_all'])->name('aptitude_question_manage.update_all');
Route::resource('/aptitude_question_manage', App\Http\Controllers\AptitudeQuestionManageController::class)->only(['index','create','store','destroy']);

// ユーザーマスター
Route::resource('user', App\Http\Controllers\UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

// 事業所マスター
Route::resource('office', App\Http\Controllers\OfficeController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

//ログイン後の画面
Route::get("/user_page", [App\Http\Controllers\UserpageController::class, "index"])->name("user_page");

// チャットルーム
Route::resource("chat_room", App\Http\Controllers\ChatRoomController::class)->only(["index", "create", "store", "edit", "update", "destroy"]);

// チャット画面
Route::get('/chat/{chat_room_id}/getChatLogJson', [App\Http\Controllers\ChatController::class, "getChatLogJson"]);
Route::get('/chat/{chat_room_id}/getNewChatLogJson', [App\Http\Controllers\ChatController::class, "getNewChatLogJson"]);
Route::get('/chat/{chat_room_id}/{chat_text_id}/getOldChatLogJson', [App\Http\Controllers\ChatController::class, "getOldChatLogJson"]);
Route::post('/chat/{chat_room_id}/storeChatJson', [App\Http\Controllers\ChatController::class, "storeChatJson"]);
Route::post("/chat/multiStore", [App\Http\Controllers\ChatController::class, "multiStore"])->name("chat.multiStore");
Route::resource("chat", App\Http\Controllers\ChatController::class)->only(["index", "show", "store"]);

//////////// API /////////////////////////////////

// ※テスト用
Route::get('/api_test', [App\Http\Controllers\ApiController::class, 'api_test'])->name('api_test');

// ユーザー
Route::POST('/api/v1.0/get/users.json', [App\Http\Controllers\ApiController::class, "ApiGetUsers"]);
Route::POST('/api/v1.0/set/users.json', [App\Http\Controllers\ApiController::class, "ApiStoreUsers"]);
Route::PUT('/api/v1.0/set/users.json', [App\Http\Controllers\ApiController::class, "ApiUpdateUsers"]);
Route::DELETE('/api/v1.0/set/users.json', [App\Http\Controllers\ApiController::class, "ApiDeleteUsers"]);
// 事業所
Route::POST('/api/v1.0/get/offices.json', [App\Http\Controllers\ApiController::class, "ApiGetOffices"]);
// Route::POST('/api/v1.0/set/offices.json', [App\Http\Controllers\ApiController::class, "ApiStoreOffices"]);
Route::PUT('/api/v1.0/set/offices.json', [App\Http\Controllers\ApiController::class, "ApiUpdateOffices"]);
// Route::DELETE('/api/v1.0/set/offices.json', [App\Http\Controllers\ApiController::class, "ApiDeleteOffices"]);
// 予定通知
Route::POST('/api/v1.0/get/notifications.json', [App\Http\Controllers\ApiController::class, "ApiGetNotifications"]);
Route::POST('/api/v1.0/set/notifications.json', [App\Http\Controllers\ApiController::class, "ApiStoreNotifications"]);
Route::PUT('/api/v1.0/set/notifications.json', [App\Http\Controllers\ApiController::class, "ApiUpdateNotifications"]);
Route::DELETE('/api/v1.0/set/notifications.json', [App\Http\Controllers\ApiController::class, "ApiDeleteNotifications"]);

// チャットルーム
Route::POST('/api/v1.0/get/chat_rooms.json', [App\Http\Controllers\ApiController::class, "ApiGetChatRooms"]);
Route::POST('/api/v1.0/set/chat_rooms.json', [App\Http\Controllers\ApiController::class, "ApiStoreChatRooms"]);
Route::PUT('/api/v1.0/set/chat_rooms.json', [App\Http\Controllers\ApiController::class, "ApiUpdateChatRooms"]);
Route::DELETE('/api/v1.0/set/chat_rooms.json', [App\Http\Controllers\ApiController::class, "ApiDeleteChatRooms"]);

// チャット
Route::POST('/api/v1.0/get/chatExistUnread.json', [App\Http\Controllers\ApiController::class, "ApiChatExistUnread"]);


//---------- リレーション -----------------------

// 予定通知__ユーザー
Route::POST('/api/v1.0/get/notification__user.json', [App\Http\Controllers\ApiController::class, "ApiGetNotificationUser"]);

// チャットルーム__ユーザー
Route::POST("/api/v1.0/get/chat_room__user.json", [App\Http\Controllers\ApiController::class, "ApiGetChatRoomUser"]);
Route::POST('/api/v1.0/set/chat_room__user.json', [App\Http\Controllers\ApiController::class, "ApiStoreChatRoomUser"]);
Route::PUT('/api/v1.0/set/chat_room__user.json', [App\Http\Controllers\ApiController::class, "ApiUpdateChatRoomUser"]);
Route::DELETE('/api/v1.0/set/chat_room__user.json', [App\Http\Controllers\ApiController::class, "ApiDeleteChatRoomUser"]);

//URI例。取得系はget、登録系はset。
// /api/v1.0/get/users.json
// /api/v1.0/get/offices.json
// /api/v1.0/set/users.json
