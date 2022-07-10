<?php

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

/*
 |--------------------------------------------------------------------------
 | API call header params after login
 |--------------------------------------------------------------------------
 |
 | ‘headers’ => [
 |   ‘Accept’ => ‘application/json’,
 |   ‘Authorization’ => ‘Bearer ‘.$accessToken,
 | ]
 */


// API Routes with prefix
Route::group(['namespace' => 'API', 'middleware' => 'api.client'], function () {
    // V1 version
    Route::group(['prefix' => 'v1'], function () {
        Route::post('login', 'UserController@login')->name('api.v1.login');
        //Route::post('register', 'UserController@register');

        Route::post('home/data', 'HomeController@data')->name('api.v1.home-page.data');

        // Logged users routes
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('details', 'UserController@details')->name('api.v1.user.details');
        });
    });
});