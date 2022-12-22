<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserCommunityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

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
// Route::get('/communities', [CommunityController::class, 'index'])->name('communities')->middleware('auth');
Auth::routes();

Route::get('/test', function () {
    return Auth()->user()->communities;
});
Route::post('/follow', [UserCommunityController::class, 'follow']);

// Route::get('/popular', [PostController::class, 'popular'])->name('posts.popular');

Route::get('/post/{slug}', [PostController::class, 'show'])->name('posts.show');

// routes that should be authenticated
Route::group(['middleware' => ['auth', 'isMembre'], 'as' => 'posts.'], function () {
    
    Route::get('/share', [PostController::class, 'create'])->name('share');
    
    Route::post('/post/store', [PostController::class, 'store'])->name('store'); 
    
    Route::delete('/post/{id}/delete', [PostController::class, 'delete'])->name('delete'); 
    
    Route::get('/post/{slug}/edit', [PostController::class, 'edit'])->name('edit');   
    
    Route::put('/post/{id}/update', [PostController::class, 'update'])->name('update'); 

});

Route::post('/post/{id}/{action}', [PostController::class, 'action'])->name('action'); 

Route::group(['middleware' => ['auth', 'isMembre'], 'as' => 'comments.'], function () {
    
    Route::post('/comments/{id}/store', [CommentController::class, 'store'])->name('store');

    Route::delete('/comments/{id}/delete', [CommentController::class, 'delete'])->name('delete');   
    
    Route::patch('/comments/{id}/update', [CommentController::class, 'update'])->name('update');   
    
});
Route::post('/comments/{id}/{action}', [CommentController::class, 'action'])->name('action');   


Route::get('/community/{slug}/{status?}', [CommunityController::class, 'community'])->name('communities.index');
Route::group(['middleware' => ['auth', 'isMembre'], 'as' => 'communities.'], function () {
});

Route::get('/{status?}', [PostController::class, 'index'])->name('home');
Route::get('/user/{username}', [UserController::class, 'show'])->name('users.show');

// Route::group([])
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('isMembre');
