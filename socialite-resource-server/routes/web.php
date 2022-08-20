<?php

use App\Http\Controllers\AuthController;
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
})->name('index');

Route::get('/auth/redirect', [AuthController::class, 'redirectForAuthentication'])->name('auth.redirect');
Route::get('/auth/callback', [AuthController::class, 'handleCallbackForAuthentication'])->name('auth.callback');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
