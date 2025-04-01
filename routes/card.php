<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/card')->as('card.')->middleware('auth')->group(function() {
    Route::get('/index', 'CardController@index')->name('index');
    Route::get('/superadmin_index', 'CardController@superadmin_index')->name('superadmin_index');
    Route::get('/create', 'CardController@create')->name('create');
    Route::post('/store', 'CardController@store')->name('store');
    Route::get('/edit/{card}', 'CardController@edit')->name('edit');
    Route::get('/view_rent/{card}', 'CardController@view_rent')->name('view_rent');
    Route::post('/update/{card}', 'CardController@update')->name('update');
    Route::get('/destroy/{card}', 'CardController@destroy')->name('destroy');
    Route::post('/setApprove', 'CardController@setApprove')->name('setApprove');
    Route::get('/setReject/{card}', 'CardController@setReject')->name('setReject');
    Route::get('/setCase/{card}', 'CardController@setCase')->name('setCase');
});
