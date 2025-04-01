<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/expense')->as('expense.')->middleware('auth')->group(function() {
    Route::get('/index', 'ExpenseController@index')->name('index');
    Route::post('/store', 'ExpenseController@store')->name('store');
    Route::get('/destroy/{expense}', 'ExpenseController@destroy')->name('destroy');
});
