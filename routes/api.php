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
            Route::get('list',      'App\Http\Controllers\Api\Desktop\Users\UsersController@list')->name('.list');
            Route::post('register', 'App\Http\Controllers\Api\Desktop\AuthController@register')->name('.register');
            Route::put('situation', 'App\Http\Controllers\Api\Desktop\Users\UsersController@situationUser')->name('.situation');
            Route::put('edit',      'App\Http\Controllers\Api\Desktop\Users\UsersController@editUser')->name('.edit');
        });

        Route::prefix('denunciations')->name('denunciations')->group(function () {
            Route::get('list', 'App\Http\Controllers\Api\Desktop\Denunciations\DenunciationsController@list')->name('.list');
        });

    });

});

Route::fallback(function () {
    return response(['message' => 'Route Not Found'],404);
});
