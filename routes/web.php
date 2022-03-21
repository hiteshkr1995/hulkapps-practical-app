<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

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

Auth::routes();

Route::get('/', [PostController::class, 'index'])->name('welcome');

Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password-update');

Route::post('/posts/{post}/comments', [PostController::class, 'commentStore'])->name('posts.comments.store');

Route::resource('posts', PostController::class)
->except(['index']);