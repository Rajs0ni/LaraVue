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
Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1'], function () {
    Route::group(['prefix' => 'guest', 'namespace' => 'Guest'], function () {
        // AuthController
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/register', 'AuthController@register');
            Route::post('/verify', 'AuthController@verify');
            Route::post('/login', 'AuthController@login');
            Route::post('/logout', 'AuthController@logout');
        });
    });

    Route::group(
        [
            'prefix' => 'member',
            'namespace' => 'Member',
            'middleware' => 'auth:api'
        ],
        function () {
            // TodoController
            Route::group(['prefix' => 'todo'], function () {
                Route::post('/list', 'TodoController@list');
                Route::post('/get', 'TodoController@get');
                Route::post('/create', 'TodoController@create');
                Route::post('/update', 'TodoController@update');
                Route::post('/delete', 'TodoController@delete');
            });
        }
    );
});
