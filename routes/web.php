<?php

use App\Http\Controllers\Admin\AircraftsController;
use App\Http\Controllers\Admin\FlightsController;
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
    return view('welcome');
});



Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class,'index'])->name('admin');
Route::resource('/admin/flights', FlightsController::class)->names('admin.flights');
Route::post('/admin/flights/citi-of-flights', [App\Http\Controllers\Admin\FlightsController::class,'citiOfFlights'])->name('admin.flights.citi-of-flights');
// Route::post('/admin/flights/country-of-arrival', [App\Http\Controllers\Admin\FlightsController::class,'countryOfArrival'])->name('admin.flights.country-of-arrival');



Route::resource('/admin/aircrafts', AircraftsController::class)->names('admin.aircrafts');
