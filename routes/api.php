<?php

use App\Http\Controllers\Ifood\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(ApiController::class)->group(function(){
    //rota para pegar o token e salvar no banco de dados
    Route::get('/token','getToken');
    Route::get('/produtos','getProtudos');
    Route::post('/produto','postProduto');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
