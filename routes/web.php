<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/small_dashboard', [App\Http\Controllers\HomeController::class, 'small_dashboard'])->name('small_dashboard');
Route::get('/home2', [App\Http\Controllers\HomeController::class, 'index2'])->name('home2');
Route::get('/customer_view', [App\Http\Controllers\HomeController::class, 'customer_view'])->name('customer_view');

//cronjob generate invoice
Route::get('/monthly_invoice', [App\Http\Controllers\Controller::class, 'monthly_invoice'])->name('monthly_invoice');
