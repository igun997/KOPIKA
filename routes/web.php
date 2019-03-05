<?php

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

Route::get('/', "FrontController@index");
Route::get('/getrecipe/{id}', "FrontController@getrecipe");
//API
Route::get('/api/v1', "ApiController@index");
Route::post('/api/v1', "ApiController@index");
Route::post('/api/v1/getrecipes',"ApiController@getRecipes");
Route::post('/api/v1/saverecipes',"ApiController@saveRecipes");
