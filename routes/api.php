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

Route::get('/', function () {
    return 'Hello World';
});

Route::get('test', 'Api\TestController@index')->name('test.index');
Route::prefix('/auth')->middleware('api')->group(function () {
    Route::post('/register', 'Api\AuthController@register');
    Route::post('/login', 'Api\AuthController@login');
    // Route::post('/logout', 'Api\AuthController@logout');
});
Route::prefix('/me')->middleware('jwt.verify')->group(function () {
    Route::post('/logout', 'Api\AuthController@logout');
    Route::get('/information', 'Api\AuthController@information');
});

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {
//     Route::post('/login', 'Auth\LoginController@login');
//     Route::post('/register', 'Auth\RegisterController@register');
//     Route::post('/logout', 'Auth\AuthController@logout');
//     Route::post('/refresh', 'Auth\AuthController@refresh');
//     Route::get('/user-profile', 'Auth\AuthController@userProfile');
//     Route::post('/change-pass', 'Auth\AuthController@changePassWord');    
// });
