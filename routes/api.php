<?php

use App\Http\Controllers\Api\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApiController::class)->group(function(){
    //testado
    Route::post('/getToken','getToken');
    //testado
    Route::get('/getProdutos','getProdutos');
    //testado
    Route::get('/getCatalogos','getCatalogos');
    Route::post('/postProduto','postProdutos');
    Route::get('/refreshToken','getRefreshToken');

    Route::post('/postItem','postItem');

    Route::get('/getCatalogo','getCatalogo');

    Route::get('/getCategoria','getCategoria');
});



