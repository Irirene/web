<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//comment
Route::controller(CommentController::class)->group(function(){
    Route::get('/comment/index', 'index');
    Route::post('/comment', 'store')->middleware('auth:sanctum');
    Route::get('/comment/{comment}/edit', 'edit');
    Route::get('/comment/{comment}/delete', 'delete');
    Route::get('/comment/{comment}', 'update');
    Route::get('/comment/{comment}/accept', 'accept');
    Route::get('/comment/{comment}/reject', 'reject');
    
});

//artiecle
Route::resource('article', ArticleController::class)->middleware('auth:sanctum');

//Auth
Route::get('signin', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'register']);
Route::get('signup', [AuthController::class, 'signup'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

//Main
Route::get('main', [MainController::class, 'index']);
Route::get('gallery/{img}', [MainController::class, 'show']);

Route::get('/', function () {
    return view('layout');
});
