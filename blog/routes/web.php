<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

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

//artiiecle
Route::resource('article', ArticleController::class);

//Auth
Route::get('signin', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'register']);

//Main
Route::get('main', [MainController::class, 'index']);
Route::get('gallery/{img}', [MainController::class, 'show']);

Route::get('/', function () {
    return view('layout');
});
