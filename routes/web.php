<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pengajuan\PengajuanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Pengajuan\Low\LowPengajuanController;
use App\Http\Controllers\Pengajuan\File\FilePengajuanController;
use App\Http\Controllers\Pengajuan\Middle\MiddlePengajuanController;

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
    Route::get('upload-file/low/{id}', [LowPengajuanController::class, 'create']);
    Route::post('upload-file/low/{id}', [LowPengajuanController::class, 'store']);
    Route::post('upload-file/low/{id}/send', [LowPengajuanController::class, 'send']);
    Route::post('upload-file/low/{id}/approve', [LowPengajuanController::class, 'approve']);
    Route::get('upload-file/middle/{id}', [MiddlePengajuanController::class, 'create']);
    Route::post('upload-file/middle/{id}', [MiddlePengajuanController::class, 'store']);
    Route::post('upload-file/middle/{id}/send', [MiddlePengajuanController::class, 'send']);
    Route::post('upload-file/middle/{id}/approve', [MiddlePengajuanController::class, 'approve']);
    Route::get('detail-file/{id}/{filename}', [FilePengajuanController::class, 'create']);
    Route::post('detail-file/{id}/{filename}/komentar', [FilePengajuanController::class, 'store_komentar']);
    Route::post('detail-file/{id}/{filename}/approve', [FilePengajuanController::class, 'approve']);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('notifikasi', [NotifikasiController::class, 'create']);
    Route::post('notifikasi', [NotifikasiController::class, 'store']);
    Route::delete('notifikasi', [NotifikasiController::class, 'destroy']);
});

// Route::middleware('auth')->prefix('admin')->group(function () {
//     Route::get('dashboard', function() {
//         return view('admin.dashboard')->with('user', Auth::user());
//     });
//     Route::get('detail', function() {
//         return view('admin.detail')->with('user', Auth::user());
//     });
//     Route::get('berkas', function() {
//         return view('admin.berkas')->with('user', Auth::user());
//     });
//     Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
// });
