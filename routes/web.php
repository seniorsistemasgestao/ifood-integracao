<?php

use App\Http\Controllers\User\UserController;
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

Route::controller(UserController::class)->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/', 'login')->name('home');

        Route::get('/cadastro', 'cadastrarCredenciais')->name('get.cadastro');
        Route::post('/cadastro', 'postCredencial')->name('post.cadastro');

        Route::post('/login', 'postLogin')->name('post.login');
        Route::get('/login', 'login')->name('get.login');
    });





    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', "dashboard")->name('get.dashbaord');
        Route::post('/logout','logout')->name('post.logout');
    });
});
