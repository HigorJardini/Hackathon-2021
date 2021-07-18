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

    Route::group(function () {

        Route::prefix('users')->name('users')->group(function () {
            Route::get('list',      'App\Http\Controllers\Api\Desktop\Users\UsersController@list')->name('.list');
            Route::post('register', 'App\Http\Controllers\Api\Desktop\AuthController@register')->name('.register');
            Route::put('situation', 'App\Http\Controllers\Api\Desktop\Users\UsersController@situationUser')->name('.situation');
            Route::post('edit',      'App\Http\Controllers\Api\Desktop\Users\UsersController@editUser')->name('.edit');
        });

        Route::prefix('denunciations')->name('denunciations')->group(function () {
            Route::get('list', 'App\Http\Controllers\Api\Desktop\Denunciations\DenunciationsController@list')->name('.list');
            Route::get('details/{denunciation_id}', 'App\Http\Controllers\Api\Desktop\Denunciations\DenunciationsController@details')->name('.details');
            Route::get('details/list/status/{denunciation_id}', 'App\Http\Controllers\Api\Desktop\Denunciations\DenunciationsController@listStatus')->name('.details.list.status');
            Route::post('details/update/status/{denunciation_id}/{status_id}', 'App\Http\Controllers\Api\Desktop\Denunciations\DenunciationsController@updateStatus')->name('.details.update.status');
        });

        Route::prefix('dashboard')->name('denunciations')->group(function () {
            Route::get('home', 'App\Http\Controllers\Api\Desktop\Dashboard\DashboardController@home')->name('.home');
        });

        Route::prefix('export')->name('export')->group(function () {
            Route::get('file/{denunciation_id}', 'App\Http\Controllers\Api\Desktop\Export\ExportFileController@export')->name('.file');
        });

    });

});

Route::prefix('mobile')->group(function () {

    Route::prefix('login')->group(function () {
        Route::get('valid', 'App\Http\Controllers\Api\Mobile\AuthController@valid')->name('valid');
        Route::post('access', 'App\Http\Controllers\Api\Mobile\AuthController@login')->name('access');
    });

    Route::post('register', 'App\Http\Controllers\Api\Mobile\AuthController@register')->name('register');
    
    Route::middleware(['auth:api'])->group(function () {
        Route::prefix('denunciations')->name('denunciations')->group(function () {
            // Route::get('list', 'App\Http\Controllers\Api\Desktop\Denunciations\DenunciationsController@list')->name('.list');
            Route::post('register', 'App\Http\Controllers\Api\Mobile\Denunciations\DenunciationsController@register')->name('.register');
            Route::get('list/neighborhoods', 'App\Http\Controllers\Api\Mobile\Denunciations\DenunciationsController@listNeighborhoods')->name('.list.neighborhoods');
        });
    });
});



Route::fallback(function () {
    return response(['message' => 'Route Not Found'],404);
});
