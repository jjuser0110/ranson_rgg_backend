<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/transaction')->as('transaction.')->middleware('auth')->group(function() {
    Route::get('/index', 'TransactionController@index')->name('index');
    Route::post('/store', 'TransactionController@store')->name('store');
    Route::get('/destroy/{transaction}', 'TransactionController@destroy')->name('destroy');
});
