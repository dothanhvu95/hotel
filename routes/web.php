<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["prefix"=>"admin"],function(){

    Route::get('/login', 'Admin\AuthController@login');

    Route::get('/dashboard', 'Admin\DashboardController@dashboard');

    Route::group(["prefix"=>"user"],function(){
       
        Route::get('/', 'Admin\UserController@listUser');
    }); 

    Route::group(["prefix"=>"hotel"],function(){
       
        Route::get('/', 'Admin\HotelController@listHotel');
    });

    Route::group(["prefix"=>"booking"],function(){
       
        Route::get('/', 'Admin\BookingController@listBooking');
    });

});

