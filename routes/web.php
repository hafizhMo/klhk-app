<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    return redirect('auth/login');
});

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create']);
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', function() {
        return view('auth.password.forgot');
    });
    Route::get('reset-password', function() {
        return view('auth.password.reset');
    });
    // ! Register feature disabled on default
    // Route::get('register', function() {
    //     return view('auth.register');
    // });
});

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'create']);
    Route::get('create-file', [PengajuanController::class, 'create']);
    Route::post('create-file', [PengajuanController::class, 'store']);
    Route::get('upload-file/low/{id}', [PengajuanController::class, 'create_low']);
    Route::post('upload-file/low/{id}', [PengajuanController::class, 'store_low']);
    Route::get('upload-file/middle/{id}', [PengajuanController::class, 'create_middle']);
    Route::post('upload-file/middle/{id}', [PengajuanController::class, 'store_middle']);
    Route::get('detail-file', function() {
        return view('user.detail')->with('user', Auth::user());
    });
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/admin/dashboard', function() {
        return view('admin.dashboard')->with('user', Auth::user());
    });
    Route::get('/admin/detail', function() {
        return view('admin.detail')->with('user', Auth::user());
    });
    Route::get('/admin/berkas', function() {
        return view('admin.berkas')->with('user', Auth::user());
    });
});
