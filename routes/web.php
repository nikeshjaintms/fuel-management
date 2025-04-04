<?php

use Illuminate\Support\Facades\Route;
use App\Exports\VehiclesExport;
use App\Exports\FuelFillingExport;

use Maatwebsite\Excel\Facades\Excel;

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


Route::get('/login', [\App\Http\Controllers\AdminController::class, 'loginPage'])->name('login');
Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('login.submit');

Route::middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

    Route::controller(App\Http\Controllers\VehiclesController::class)->group(function () {
        Route::get('/vehicles', 'index')->name('admin.vehicles.index');
        Route::get('/vehicles/create', 'create')->name('admin.vehicles.create');
        Route::post('/vehicles/create', 'store')->name('admin.vehicles.store');
        Route::get('/vehicles/{id}', 'show')->name('admin.vehicles.show');
        Route::get('/vehicles/edit/{id}', 'edit')->name('admin.vehicles.edit');
        Route::put('/vehicles/edit/{id}', 'update')->name('admin.vehicles.update');
        Route::delete('/vehicles/delete/{id}', 'destroy')->name('admin.vehicles.destroy');
        Route::post('/admin/vehicles/check', 'check')->name('admin.vehicles.check');
        Route::post('/vehicles/import', 'import')->name('admin.vehicles.import');
    });
    Route::get('/vehicle-info/export', function () {
        return Excel::download(new VehiclesExport, 'VehicleExport.xlsx');
    })->name('admin.vehicles.export');
    Route::controller(\App\Http\Controllers\CustomerController::class)->group(function () {
        Route::get('/customer-info', 'index')->name('admin.customer_info.index');
        Route::get('/customer-info/create', 'create')->name('admin.customer_info.create');
        Route::post('/customer-info/create', 'store')->name('admin.customer_info.store');
        Route::get('/customer-info/{id}', 'show')->name('admin.customer_info.show');
        Route::get('/customer-info/edit/{id}', 'edit')->name('admin.customer_info.edit');
        Route::put('/customer-info/edit/{id}', 'update')->name('admin.customer_info.update');
        Route::delete('/customer-info/delete/{id}', 'destroy')->name('admin.customer_info.destroy');
        Route::post('/customer-info/import', 'import')->name('admin.customer_info.import');
    });

    Route::controller(\App\Http\Controllers\FuelFillingController::class)->group(function () {
        Route::get('/fuel-filling', 'index')->name('admin.fuel_filling.index');
        Route::get('/fuel-filling/create', 'create')->name('admin.fuel_filling.create');
        Route::post('/fuel-filling/create', 'store')->name('admin.fuel_filling.store');
        Route::get('/fuel-filling/{id}', 'show')->name('admin.fuel_filling.show');
        Route::get('/fuel-filling/edit/{id}', 'edit')->name('admin.fuel_filling.edit');
        Route::put('/fuel-filling/edit/{id}', 'update')->name('admin.fuel_filling.update');
        Route::delete('/fuel-filling/delete/{id}', 'destroy')->name('admin.fuel_filling.destroy');
        Route::get('/fuel-filling-pdf','genratePDF')->name('admin.fuel_filling.pdf');
        Route::post('/fuel-filling-pdf','custompdf')->name('admin.fuel_filling.custompdf');
    });

    // Route::get('/fuel-filling/export', function () {
    Route::get('fuel-filling-export', function () {
        return Excel::download(new FuelFillingExport, 'FuelFillingExport.xlsx');
    })->name('admin.fuel_filling.export');

    Route::controller(\App\Http\Controllers\DriverController::class)->group(function () {
        Route::get('/driver', 'index')->name('admin.driver.index');
        Route::get('/driver/create', 'create')->name('admin.driver.create');
        Route::post('/driver/create', 'store')->name('admin.driver.store');
        Route::get('/driver/{id}', 'show')->name('admin.driver.show');
        Route::get('/driver/edit/{id}', 'edit')->name('admin.driver.edit');
        Route::put('/driver/edit/{id}', 'update')->name('admin.driver.update');
        Route::delete('/driver/delete/{id}', 'destroy')->name('admin.driver.destroy');
        Route::post('/driver/import', 'import')->name('admin.driver.import');
    });

    Route::controller(\App\Http\Controllers\MasterdataController::class)->group(function () {
        Route::get('/owner', 'index')->name('admin.owner.index');
        Route::get('/owner/create', 'create')->name('admin.owner.create');
        Route::post('/owner/create', 'store')->name('admin.owner.store');
        Route::get('/owner/{id}', 'show')->name('admin.owner.show');
        Route::get('/owner/edit/{id}', 'edit')->name('admin.owner.edit');
        Route::put('/owner/edit/{id}', 'update')->name('admin.owner.update');
        Route::delete('/owner/delete/{id}', 'destroy')->name('admin.owner.destroy');
        Route::post('/owner/import', 'import')->name('admin.owner.import');
    });

    Route::controller(\App\Http\Controllers\RTOController::class)->group(function () {
        Route::get('/rto', 'index')->name('admin.rto.index');
        Route::get('/rto/create', 'create')->name('admin.rto.create');
        Route::post('/rto/create', 'store')->name('admin.rto.store');
        Route::get('/rto/{id}', 'show')->name('admin.rto.show');
        Route::get('/rto/edit/{id}', 'edit')->name('admin.rto.edit');
        Route::put('/rto/edit/{id}', 'update')->name('admin.rto.update');
        Route::delete('/rto/delete/{id}', 'destroy')->name('admin.rto.destroy');
        Route::post('/rto/checkVehicle', 'checkVehicle')->name('admin.rto.checkVehicle');
        Route::post('/rto/paytax/{id}', 'paytax')->name('admin.rto.pay_tax');
    });
});
