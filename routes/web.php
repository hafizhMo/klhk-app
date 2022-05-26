<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Pengajuan\TemporaryPengajuanController;

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
    // return view('auth/login');
});

Route::get('/auth/login', [AuthenticatedSessionController::class, 'create']);

Route::post('/auth/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/auth/forgot-password', function() {
    return view('auth/password/forgot');
});

Route::get('/auth/reset-password', function() {
    return view('auth/password/reset');
});

Route::get('/auth/register', function() {
    return view('auth/register');
});

Route::get('/user/dashboard', function() {
    return view('user/dashboard');
});

Route::get('/user/create-file', function() {
    return view('user.create');
});

Route::post('/user/create-file', [TemporaryPengajuanController::class, 'redirect']);

Route::get('/user/upload-file/low', function() {
    return view('uploads/low');
});

Route::get('/user/upload-file/middle', function() {
    return view('uploads/middle');
});

Route::get('/user/detail-file', function() {
    return view('user/detail');
});

Route::get('/admin/dashboard', function() {
    return view('admin/dashboard');
});

Route::get('/admin/detail', function() {
    return view('admin/detail');
});

Route::get('/admin/berkas', function() {
    return view('admin/berkas');
});