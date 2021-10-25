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

// ユーザーマスター
Route::prefix('users')->group(function () {
    // 見た目確認
    Route::get('/', function () {
        return view('user_master_index');
    });
    Route::get('/create', function () {
        return view('user_master_create');
    });
    Route::get('/edit', function () {
        return view('user_master_edit');
    });
});
