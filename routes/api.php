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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix'     => 'auth'
], function ($router) {

    Route::post('login', 'App\Http\Controllers\APIs\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\APIs\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\APIs\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\APIs\AuthController@me');

});
