<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



// Route::get('/index', function () {
//     return view('index');
// });
// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/login', [\App\Http\Controllers\AdminController::class, 'loginPage'])->name('login');
Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('login.submit');

Route::middleware('auth:admin')->group(function (){
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

    Route::controller(App\Http\Controllers\VehiclesController::class)->group(function(){
        Route::get('/vehicles','index')->name('admin.vehicles.index');
        Route::get('/vehicles/create','create')->name('admin.vehicles.create');
        Route::post('/vehicles/create','store')->name('admin.vehicles.store');
        Route::get('/vehicles/{id}','show')->name('admin.vehicles.show');
        Route::get('/vehicles/edit/{id}','edit')->name('admin.vehicles.edit');
        Route::put('/vehicles/edit/{id}','update')->name('admin.vehicles.update');
        Route::delete('/vehicles/delete/{id}','destroy')->name('admin.vehicles.destroy');
        Route::get('/vehicles/alert', 'alertmsg')->name('admin.vehicles.msg');
        Route::post('/admin/vehicles/check', 'check')->name('admin.vehicles.check');
    });

    Route::controller(\App\Http\Controllers\CustomerController::class)->group(function(){
        Route::get('/customer_info','index')->name('admin.customer_info.index');
        Route::get('/customer_info/create','create')->name('admin.customer_info.create');
        Route::post('/customer_info/create','store')->name('admin.customer_info.store');
        Route::get('/customer_info/{id}','show')->name('admin.customer_info.show');
        Route::get('/customer_info/edit/{id}','edit')->name('admin.customer_info.edit');
        Route::put('/customer_info/edit/{id}','update')->name('admin.customer_info.update');
        Route::delete('/customer_info/delete/{id}','destroy')->name('admin.customer_info.destroy');
    });

    Route::controller(\App\Http\Controllers\FuelFillingController::class)->group(function(){
        Route::get('/fuel_filling','index')->name('admin.fuel_filling.index');
        Route::get('/fuel_filling/create','create')->name('admin.fuel_filling.create');
        Route::post('/fuel_filling/create','store')->name('admin.fuel_filling.store');
        Route::get('/fuel_filling/{id}','show')->name('admin.fuel_filling.show');
        Route::get('/fuel_filling/edit/{id}','edit')->name('admin.fuel_filling.edit');
        Route::put('/fuel_filling/edit/{id}','update')->name('admin.fuel_filling.update');
        Route::delete('/fuel_filling/delete/{id}','destroy')->name('admin.fuel_filling.destroy');
    });

    Route::controller(\App\Http\Controllers\DriverController::class)->group(function(){
        Route::get('/driver','index')->name('admin.driver.index');
        Route::get('/driver/create','create')->name('admin.driver.create');
        Route::post('/driver/create','store')->name('admin.driver.store');
        Route::get('/driver/{id}','show')->name('admin.driver.show');
        Route::get('/driver/edit/{id}','edit')->name('admin.driver.edit');
        Route::put('/driver/edit/{id}','update')->name('admin.driver.update');
        Route::delete('/driver/delete/{id}','destroy')->name('admin.driver.destroy');
    });

});
