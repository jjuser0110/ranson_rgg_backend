<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/withdraw')->as('withdraw.')->middleware('auth')->group(function() {
    Route::get('/index', 'WithdrawController@index')->name('index');
    Route::post('/store', 'WithdrawController@store')->name('store');
    Route::get('/view/{withdraw}', 'WithdrawController@view')->name('view');
    Route::get('/destroy/{withdraw}', 'WithdrawController@destroy')->name('destroy');
});
