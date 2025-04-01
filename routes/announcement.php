<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/announcement')->as('announcement.')->middleware('auth')->group(function() {
    Route::get('/index', 'AnnouncementController@index')->name('index');
    Route::post('/store', 'AnnouncementController@store')->name('store');
    Route::get('/destroy/{announcement}', 'AnnouncementController@destroy')->name('destroy');
    Route::get('/setActive/{announcement}', 'AnnouncementController@setActive')->name('setActive');
    Route::get('/setInActive/{announcement}', 'AnnouncementController@setInActive')->name('setInActive');
});
