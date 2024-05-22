<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvitationController;

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

Route::controller(InvitationController::class)
    ->prefix('invitations')
    ->as('invitations.')
    ->group(function () {
        Route::post('/invite', 'invite')->name('store');
        Route::post('/accept/{invitation:code}', 'acceptInvite')->name('accept');
    });

Route::controller(DailyLogController::class)
    ->prefix('daily-logs')
    ->as('daily-logs.')
    ->group(function () {
        Route::post('/', 'store')->name('store')->middleware('name.blocker');
        Route::put('/{dailyLog}', 'update')->name('update')->where('dailyLog', '[0-9]+');
        Route::delete('/{dailyLog}', 'destroy')->name('delete')->where('dailyLog', '[0-9]+');
    });

Route::controller(ProfileController::class)
    ->prefix('profile')
    ->as('profile.')
    ->group(function () {
        Route::put('/update-avatar', 'updateAvatar')->name('update-avatar');
    });
