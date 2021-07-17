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

Route::prefix('desktop')->group(function () {

    Route::post('login', 'App\Http\Controllers\Api\Desktop\AuthController@login')->name('login');

    Route::middleware(['auth:api'])->group(function () {

        Route::prefix('users')->name('users')->group(function () {
            // Route::post('list', 'App\Http\Controllers\Api\Desktop\AuthController@register')->name('.index');
            Route::post('register', 'App\Http\Controllers\Api\Desktop\AuthController@register')->name('.register');
        });

        Route::prefix('denunciations')->name('denunciations')->group(function () {
            Route::get('list', 'App\Http\Controllers\Api\Desktop\Denunciations\DenunciationsController@list')->name('.list');
        });

    });

});

Route::get('test', function () {
    return response(['message' => 'Route'],200);
});

Route::fallback(function () {
    return response(['message' => 'Route Not Found'],404);
});
