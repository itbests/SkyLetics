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

Route::post('/chat-bot', 'App\Http\Controllers\Api\ChatBotController@listenToReplies');

Route::group(['middleware' => ['validate.token']], function () {
    Route::post('/utilServices.getStatusList', 'App\Http\Controllers\Api\UtilServicesController@getStatusList');

    Route::post('/operatingUnit', 'App\Http\Controllers\Api\OperatingUnitController@index');
    Route::post('/operatingUnit.show', 'App\Http\Controllers\Api\OperatingUnitController@show');
    Route::post('/operatingUnit.edit', 'App\Http\Controllers\Api\OperatingUnitController@edit');

    Route::post('/users', 'App\Http\Controllers\Api\UsersController@index');
    Route::post('/users.show', 'App\Http\Controllers\Api\UsersController@show');
    Route::post('/users.edit', 'App\Http\Controllers\Api\UsersController@edit');
    Route::post('/users.changePassword', 'App\Http\Controllers\Api\UsersController@changePassword');
});
