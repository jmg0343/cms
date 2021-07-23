<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CategoriesController;

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

Auth::routes();

// grouping allows all routes within to be protected by the appointed middleware
// auth middleware prevents access to posts when logged out
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('categories', CategoriesController::class);

    Route::resource('posts', PostsController::class)->middleware(['auth']);

    Route::resource('tags', TagsController::class);

    Route::get('trashed-posts', [PostsController::class, 'trashed'])->name('trashed-posts.index');

    Route::put('restore-post/{post}', [PostsController::class, 'restore'])->name('restore-posts');
});