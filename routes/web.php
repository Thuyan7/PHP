<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/register',[\App\Http\Controllers\PublicController::class,'showRegistrationForm'])->name('register');
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);
Route::get('/login',[\App\Http\Controllers\PublicController::class,'showLoginForm'])->name('login');
Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/logout',[\App\Http\Controllers\AuthController::class,'logout'])->name('logout');
Route::get('/user/home',[\App\Http\Controllers\UserController::class,'home'])->name('user-home')->middleware('auth');
Route::get('/admin/home',[\App\Http\Controllers\AdminController::class,'home'])->name('admin-home')->middleware('auth');
Route::get('/post/create',[\App\Http\Controllers\PostController::class,'create'])->name('post.create');
Route::post('/post/create',[\App\Http\Controllers\PostController::class,'store']);
Route::get('/post', [\App\Http\Controllers\PublicController::class, 'showPost'])->name('post');
Route::get('/post/detail/{id}', [PostController::class, 'showDetailPost'])->name('post.detail');
Route::get('/introduce',[\App\Http\Controllers\PublicController::class,'showIntroduce'])->name('introduce');
Route::get('/contact',[\App\Http\Controllers\PublicController::class,'showContact'])->name('contact');
Route::get('/home',[\App\Http\Controllers\PublicController::class,'showHome'])->name('home');
Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');



