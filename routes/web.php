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
        Route::delete('/vehicles/{id}','destroy')->name('admin.vehicles.destroy');


    });
});
