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

    //testado
    Route::post('/postProduto','postProdutos');
    // ainda em teste
    Route::get('/refreshToken','getRefreshToken');
   //testado
    Route::post('/postItem','postItem');
   //testado
    Route::get('/getCatalogo','getCatalogo');
    //testado
    Route::get('/getCategorias','getCategorias');
    //testado
    Route::post('/postCategoria','postCategoria');
     //testado
    Route::delete('/deleteProduto','deleteProduto');
});



