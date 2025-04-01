<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/monthly_rent')->as('monthly_rent.')->middleware('auth')->group(function() {
    Route::get('/index', 'MonthlyRentController@index')->name('index');
});
