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

    });

});