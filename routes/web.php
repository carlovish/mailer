<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('login', [LoginController::class, 'authenticate'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('emails/{id}',[AdminController::class,'showEmails'])->name('showEmails');

Route::resource('admin', AdminController::class);
Route::resource('user', UserController::class);
Route::resource('email', EmailController::class);

Route::redirect('/', 'user');


