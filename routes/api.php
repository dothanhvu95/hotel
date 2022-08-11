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
    Route::post('/forgot-password', 'Api\AuthController@forgetPassword');
});
Route::prefix('/me')->middleware('jwt.verify')->group(function () {
    Route::post('/logout', 'Api\MeController@logout');
    Route::get('/information', 'Api\MeController@information');
    Route::post('/change-password', 'Api\MeController@changePassword');
    Route::post('/change-information', 'Api\MeController@changeInformation');
});
Route::prefix('/location')->group(function () {
    Route::get('/city', 'Api\CityController@index');
    
});
Route::prefix('/home')->group(function () {
    Route::get('/index', 'Api\HomeController@index');
    
});

Route::prefix('/hotel')->group(function () {
    Route::get('/{id}', 'Api\HotelController@index');
    
});

Route::prefix('/booking')->middleware('jwt.verify')->group(function () {
    Route::post('/hotel', 'Api\BookingController@booking');
    
});


