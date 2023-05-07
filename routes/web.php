<?php

use App\Http\Controllers\Admin\AircraftsController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\FlightsController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
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
    Route::get('/flight/view/{id}', [App\Http\Controllers\FlightsController::class,'view'])->name('flight.view');
    Route::post('/flight/allComments', [App\Http\Controllers\FlightsController::class,'allComments'])->name('flight.allComments');

Route::group(['middleware' => ['role:Admin|SuperAdmin']], function () {
    Route::get('admin/user/delete', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.delete');
    Route::resource('/admin/users', UserController::class)->names('admin.users');
});
Route::group(['middleware' => ['role:User|Admin|SuperAdmin']], function () {

    Route::get('/flights/citi-of-flights', [App\Http\Controllers\FlightsController::class,'citiOfFlights'])->name('flights.citi-of-flights');
    Route::get('/orderProcessing/edit/{id}', [App\Http\Controllers\Admin\OrdersController::class, 'editOrderProcessing'])->middleware('verified')->name('orderProcessing.edit');
    Route::post('/orderProcessing', [App\Http\Controllers\Admin\OrdersController::class, 'orderProcessing'])->middleware('verified')->name('orderProcessing');
    Route::get('/profile/booking', [App\Http\Controllers\BookingController::class, 'myBooking'])->middleware('verified')->name('profile.booking');
    Route::post('/booking/add', [App\Http\Controllers\BookingController::class, 'addBooking'])->middleware('verified')->name('booking.add');
    Route::get('/profile/delete', [App\Http\Controllers\ProfileController::class, 'destroy'])->middleware('verified')->name('profile.delete');
    Route::get('/password/changePassword/edit', [App\Http\Controllers\ProfileController::class, 'editChangePassword'])->middleware('verified')->name('password.changePassword.edit');
    Route::post('/password/changePassword', [App\Http\Controllers\ProfileController::class, 'changePassword'])->middleware('verified')->name('password.changePassword');
    Route::resource('/profile', ProfileController::class)->middleware('verified')->names('profile');
    Route::get('/flight/delete-comment', [App\Http\Controllers\FlightsController::class,'deleteComment'])->middleware('verified')->name('flight.delete-comment');
    Route::resource('/bookings', BookingController::class)->middleware('verified')->names('bookings');
    Route::post('/flight/sendingComment', [App\Http\Controllers\FlightsController::class,'sendingComment'])->middleware('verified')->name('flight.sendingComment');
    Route::get('/basket/delete', [App\Http\Controllers\BasketController::class,'destroy'])->middleware('verified')->name('basket.delete');
    Route::resource('/basket', BasketController::class)->middleware('verified')->names('basket');
    Route::post('/basket/addBasket/{id}', [App\Http\Controllers\BasketController::class, 'addBasket'])->middleware('verified')->name('basket.addBasket');

});



Route::group(['middleware' => ['role:SuperAdmin|Admin']], function () {

    Route::get('/admin/flights/citi-of-flights', [App\Http\Controllers\Admin\FlightsController::class,'citiOfFlights'])->name('admin.flights.citi-of-flights');
    Route::get('/admin/flights/country-of-flights', [App\Http\Controllers\Admin\FlightsController::class,'countryOfFlights'])->name('admin.flights.country-of-flights');
    Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class,'index'])->name('admin');
    Route::get('/admin/flights/delete', [App\Http\Controllers\Admin\FlightsController::class, 'destroy'])->name('admin.flights.delete');
    Route::resource('/admin/flights', FlightsController::class)->names('admin.flights');
    Route::get('/admin/aircrafts/delete', [App\Http\Controllers\Admin\AircraftsController::class, 'destroy'])->name('admin.aircrafts.delete');
    Route::resource('/admin/aircrafts', AircraftsController::class)->names('admin.aircrafts');
    Route::resource('/admin/orders', OrdersController::class)->names('admin.orders');
    Route::post('/admin/order/status', [App\Http\Controllers\Admin\OrdersController::class, 'changeStatus'])->name('admin.order.status');
    Route::post('/admin/order/rejectedStatus', [App\Http\Controllers\Admin\OrdersController::class, 'rejectedStatus'])->name('admin.order.rejectedStatus');
    Route::get('/admin/delivery/delete', [App\Http\Controllers\Admin\DeliveryController::class, 'destroy'])->name('admin.delivery.delete');
    Route::resource('/admin/delivery', DeliveryController::class)->names('admin.delivery');
    Route::post('admin/recovery', [App\Http\Controllers\Admin\UserController::class, 'recovery'])->name('admin.recovery');
});

Route::post('/admin/flights/place-of-classes',  [App\Http\Controllers\Admin\FlightsController::class,'placeOfClasses'])->name('admin.flights.place-of-classes');
Route::get('/getCountryApi', [App\Http\Controllers\CountrySitiApiController::class, 'getCountryApi'])->name('getCountryApi');
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Auth::routes(['verify'=>true]);


