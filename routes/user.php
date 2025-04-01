<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->as('user.')->middleware('auth')->group(function() {
    Route::get('/index', 'UserController@index')->name('index');
    Route::post('/store', 'UserController@store')->name('store');
    Route::get('/view/{user}', 'UserController@view')->name('view');
    Route::get('/resetPassword/{user}', 'UserController@resetPassword')->name('resetPassword');
    Route::get('/setInactive/{user}', 'UserController@setInactive')->name('setInactive');
    Route::get('/setActive/{user}', 'UserController@setActive')->name('setActive');
    Route::post('/changePassword', 'UserController@changePassword')->name('changePassword');
});
