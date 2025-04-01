<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/bank')->as('bank.')->middleware('auth')->group(function() {
    Route::get('/index', 'BankController@index')->name('index');
    Route::post('/store', 'BankController@store')->name('store');
    Route::get('/destroy/{bank}', 'BankController@destroy')->name('destroy');
});
