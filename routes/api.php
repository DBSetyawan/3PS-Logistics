<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['json.response']], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // access public routes
    Route::post('/login', 'AuthController@login')->name('login.api');
    Route::post('/register', 'AuthController@register')->name('register.api');

    // access private routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'AuthController@logout')->name('logout');
        Route::post('/details', 'AuthController@details')->name('detail_user');
        // Route::post('/webhook', 'AccurateCloudAPIController@AccurateNotificationWithWebhook')->name('Webhooks');
            // Route::post('/webhook', 'AccurateCloudAPIController@handle')->name('Webhooks');
            Route::post('/webhooks', 'AuthController@webhooks')->name('detail_user');

    });

    // Route::post('/webhooks', function (Request $request) {
    //     return $request->all();
    // });


});

