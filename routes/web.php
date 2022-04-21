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
    return view('auth/login');
});

Route::get('/auth/login', function() {
    return view('auth/login');
});

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
    return view('user/create');
});

Route::get('/user/upload-file', function() {
    return view('user/upload');
});

Route::get('/user/detail-file', function() {
    return view('user/detail');
});