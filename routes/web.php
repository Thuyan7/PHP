<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/register',[\App\Http\Controllers\PublicController::class,'showRegistrationForm'])->name('register');
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);
Route::get('/login',[\App\Http\Controllers\PublicController::class,'showLoginForm'])->name('login');
Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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
Route::get('/user/profile',[\App\Http\Controllers\UserController::class,'showProfilePage'])->name('user-profile');
Route::post('/user/profile/updateProfile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
Route::delete('/user/profile/deletePost/{id}', [PostController::class, 'deletePost'])->name('user.deletePost');
Route::delete('/user/profile/deleteComment/{id}', [CommentController::class,'deleteComment'])->name('user.deleteComment');



