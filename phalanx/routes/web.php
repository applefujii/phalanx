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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 通知
Route::resource('/notification', App\Http\Controllers\NotificationController::class);
Route::get('/people_list', [App\Http\Controllers\NotificationController::class, 'pepple_list'])->name('people_list');

// 体験・見学申込管理
Route::get('/trial_application_manage/{id}/check', [App\Http\Controllers\TrialApplicationManageController::class, 'check'])->name('trial_application_manage.check');
Route::put('/trial_application_manage/{id}/check_update', [App\Http\Controllers\TrialApplicationManageController::class, 'check_update'])->name('trial_application_manage.check_update');
Route::resource('/trial_application_manage', App\Http\Controllers\TrialApplicationManageController::class);

// 体験・見学申込フォーム
Route::get('/trial_application_form', [App\Http\Controllers\TrialApplicationFormController::class, 'form'])->name('trial_application_form.form');
Route::post('/trial_application_form', [App\Http\Controllers\TrialApplicationFormController::class, 'store'])->name('trial_application_form.store');
Route::get('/trial_application_form/finish', [App\Http\Controllers\TrialApplicationFormController::class, 'finish'])->name('trial_application_form.finish');

// ユーザーマスター
Route::resource('user', App\Http\Controllers\UserController::class)->only(['index']);

// チャットルーム
Route::get('/chat_room', [App\Http\Controllers\ChatRoomController::class, "index"])->name("chat_rooms.index");
Route::get("/chat_room/{id}", [App\Http\Controllers\ChatRoomController::class, "show"])->name("chat_rooms.show");
