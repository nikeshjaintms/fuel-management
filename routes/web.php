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
        Route::get('/vehicles','create')->name('vehicles.create');
        Route::post('/vehicles','store')->name('vehicles.store');

    });
});
