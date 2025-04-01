<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/rent')->as('rent.')->middleware('auth')->group(function() {
    Route::get('/index', 'RentController@index')->name('index');
    Route::post('/store', 'RentController@store')->name('store');
    Route::get('/destroy/{rent}', 'RentController@destroy')->name('destroy');
    Route::post('/storeRentItem', 'RentController@storeRentItem')->name('storeRentItem');
    Route::post('/mark_all_pay', 'RentController@mark_all_pay')->name('mark_all_pay');
    Route::get('/mark_paid/{rent_item}', 'RentController@mark_paid')->name('mark_paid');
    Route::get('/destroyitem/{rent_item}', 'RentController@destroyitem')->name('destroyitem');
});
