<?php

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

Route::post('login','Authcontroller@login');
Route::post('register','Authcontroller@register');
Route::middleware('auth:api')->group(function (){
    Route::get('view','ProductController@view');
    Route::get('show_my_products','ProductController@show_my_products');
    Route::post('create','ProductController@store');
    Route::post('show_single_product','ProductController@show_single_product');
    Route::post('update','ProductController@update');
    Route::post('serach','ProductController@serach');

});
