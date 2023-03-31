<?php

use App\Http\Controllers\Admin\AircraftsController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\FlightsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

// Auth::routes();

// Route::post('/admin/flights/country-of-arrival', [App\Http\Controllers\Admin\FlightsController::class,'countryOfArrival'])->name('admin.flights.country-of-arrival');

// Route::get('/', function () {
//     return view('/admin/index');
// });


Route::get('/', [App\Http\Controllers\FlightsController::class, 'index'])->name('/');
Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class,'index'])->name('admin');
Route::resource('/admin/flights', FlightsController::class)->names('admin.flights');
Route::post('/admin/flights/citi-of-flights', [App\Http\Controllers\Admin\FlightsController::class,'citiOfFlights'])->name('admin.flights.citi-of-flights');
Route::post('/admin/flights/place-of-classes',  [App\Http\Controllers\Admin\FlightsController::class,'placeOfClasses'])->name('admin.flights.place-of-classes');
Route::resource('/admin/aircrafts', AircraftsController::class)->names('admin.aircrafts');
Route::get('/profile/booking', [App\Http\Controllers\BookingController::class, 'myBooking'])->name('profile.booking');
Route::post('/booking/add', [App\Http\Controllers\BookingController::class, 'addBooking'])->name('booking.add');
Route::resource('/profile', ProfileController::class)->middleware('verified')->names('profile');
Route::resource('/bookings', BookingController::class)->names('bookings');
Route::get('/flight/view/{id}', [App\Http\Controllers\FlightsController::class,'view'])->name('flight.view');
Route::resource('/basket', BasketController::class)->names('basket');
Route::post('/basket/addBasket/{id}', [App\Http\Controllers\BasketController::class, 'addBasket'])->name('basket.addBasket');
Route::resource('/admin/orders', OrdersController::class)->names('admin.orders');
Route::post('/admin/order/status', [App\Http\Controllers\Admin\OrdersController::class, 'changeStatus'])->name('admin.order.status');
Route::get('/orderProcessing/edit/{id}', [App\Http\Controllers\Admin\OrdersController::class, 'editOrderProcessing'])->name('orderProcessing.edit');
Route::post('/orderProcessing', [App\Http\Controllers\Admin\OrdersController::class, 'orderProcessing'])->name('orderProcessing');
Route::resource('/admin/delivery', DeliveryController::class)->names('admin.delivery');
Route::resource('/admin/users', UserController::class)->names('admin.users');
Route::post('admin/recovery', [App\Http\Controllers\Admin\UserController::class, 'recovery'])->name('admin.recovery');

Auth::routes(['verify'=>true]);


