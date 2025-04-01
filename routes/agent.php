<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/agent')->as('agent.')->middleware('auth')->group(function() {
    Route::get('/index', 'AgentController@index')->name('index');
    Route::post('/store', 'AgentController@store')->name('store');
    Route::get('/reset_password/{agent}', 'AgentController@reset_password')->name('reset_password');
});
