<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/customer')->as('customer.')->middleware('auth')->group(function() {
    Route::get('/index', 'CustomerController@index')->name('index');
    Route::get('/view/{user}', 'CustomerController@view')->name('view');
    Route::post('/storeCard/{user}', 'CustomerController@storeCard')->name('storeCard');
    Route::post('/editInvoiceItem', 'CustomerController@editInvoiceItem')->name('editInvoiceItem');
    Route::get('/destroyItems/{invoice_item}', 'CustomerController@destroyItems')->name('destroyItems');
    Route::get('/generateInvoice/{user}', 'CustomerController@generateInvoice')->name('generateInvoice');
    Route::get('/removeCard/{card}', 'CustomerController@removeCard')->name('removeCard');
    Route::post('/updateCard', 'CustomerController@updateCard')->name('updateCard');
    Route::post('/pay_receive', 'CustomerController@pay_receive')->name('pay_receive');
    Route::get('/destroyPayment/{payment}', 'CustomerController@destroyPayment')->name('destroyPayment');
});
