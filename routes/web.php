<?php

use Illuminate\Support\Facades\Route;
use App\Exports\VehiclesExport;
use App\Exports\FuelFillingExport;
use App\Models\Notification;
use Illuminate\Http\Request;
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
    // Route::get('/', [App\Http\Controllers\DashBoardController::class, 'index'])->name('index');
    Route::get('/', function(){
        return view('index');
    })->name('index');

    Route::get('/fetch-notifications', function () {
        $notifications = Notification::where('is_read', false)->limit(3)->orderBy('id','DESC')->get();
        return response()->json($notifications);
    })->name('notifications.fetch');

    Route::get('/dashboard-data', [App\Http\Controllers\DashboardController::class, 'getData']);


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
        Route::post('/customer/check-gst', 'customerGst')->name('admin.check.customer_gst');

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
        Route::post('/rto/bulk_pay', 'bulkPay')->name('admin.tax.bulk_pay');
    });

    Route::controller(\App\Http\Controllers\PUCController::class)->group(function(){
        Route::get('/puc', 'index')->name('admin.puc.index');
        Route::get('/puc/create', 'create')->name('admin.puc.create');
        Route::post('/puc/create','store')->name('admin.puc.store');
        Route::get('/puc/edit/{id}', 'edit')->name('admin.puc.edit');
        Route::put('/puc/edit/{id}', 'update')->name('admin.puc.update');
        Route::delete('/puc/delete/{id}', 'destroy')->name('admin.puc.destroy');
        Route::post('/puc/checkVehicle', 'checkVehicle')->name('admin.puc.checkVehicle');

    });

    Route::controller(App\Http\Controllers\FitnessController::class)->group(function(){
        Route::get('/fitness', 'index')->name('admin.fitness.index');
        Route::get('/fitness/create', 'create')->name('admin.fitness.create');
        Route::post('/fitness/create','store')->name('admin.fitness.store');
        Route::get('/fitness/edit/{id}', 'edit')->name('admin.fitness.edit');
        Route::put('/fitness/edit/{id}', 'update')->name('admin.fitness.update');
        Route::delete('/fitness/delete/{id}', 'destroy')->name('admin.fitness.destroy');
        Route::post('/fitness/checkVehicle', 'checkVehicle')->name('admin.fitness.checkVehicle');
    });

    Route::controller(App\Http\Controllers\PolicyController::class)->group(function(){
        Route::get('/policy', 'index')->name('admin.policy.index');
        Route::get('/policy/create', 'create')->name('admin.policy.create');
        Route::post('/policy/create','store')->name('admin.policy.store');
        Route::get('/policy/edit/{id}', 'edit')->name('admin.policy.edit');
        Route::put('/policy/edit/{id}', 'update')->name('admin.policy.update');
        Route::delete('/policy/delete/{id}', 'destroy')->name('admin.policy.destroy');
        Route::post('/policy/checkVehicle', 'checkVehicle')->name('admin.policy.checkVehicle');
        Route::post('/admin/policy/checkPolicy', 'checkPolicy')->name('admin.policy.checkPolicy');
    });

    Route::controller(App\Http\Controllers\VendorController::class)->group(function(){
        Route::get('/vendor', 'index')->name('admin.vendor.index');
        Route::get('/vendor/create', 'create')->name('admin.vendor.create');
        Route::post('/vendor/create','store')->name('admin.vendor.store');
        Route::get('/vendor/{id}', 'show')->name('admin.vendor.show');
        Route::get('/vendor/edit/{id}', 'edit')->name('admin.vendor.edit');
        Route::put('/vendor/edit/{id}', 'update')->name('admin.vendor.update');
        Route::delete('/vendor/delete/{id}', 'destroy')->name('admin.vendor.destroy');
        Route::post('/vendor/check-gst', 'checkGst')->name('admin.check.vendor_gst');
    });

    Route::controller(App\Http\Controllers\LoanController::class)->group(function(){
        Route::get('/loan','index')->name('admin.loan.index');
        Route::get('/loan/create','create')->name('admin.loan.create');
        Route::post('/loan/create','store')->name('admin.loan.store');
        Route::get('/loan/{id}','show')->name('admin.loan.show');
        Route::get('/loan/edit/{id}','edit')->name('admin.loan.edit');
        Route::put('/loan/edit/{id}','update')->name('admin.loan.update');
        Route::delete('/loan/delete/{id}','destroy')->name('admin.loan.destroy');
        Route::post('/loan/checkVehicle','checkVehicle')->name('admin.loan.checkVehicle');
        Route::post('/loan/update-emi', 'updateEmiPaid')->name('admin.loan.updateEmiPaid');
    });


    Route::controller(App\Http\Controllers\MaintenaceController::class)->group(function(){
        Route::get('/maintenance','index')->name('admin.maintenance.index');
        Route::get('/maintenance/create','create')->name('admin.maintenance.create');
        Route::post('/maintenance/create','store')->name('admin.maintenance.store');
        Route::get('/maintenance/{id}','show')->name('admin.maintenance.show');
        Route::get('/maintenance/edit/{id}','edit')->name('admin.maintenance.edit');
        Route::put('/maintenance/edit/{id}','update')->name('admin.maintenance.update');
        Route::delete('/maintenance/delete/{id}','destroy')->name('admin.maintenance.destroy');
        Route::post('/maintenance/checkVehicle','checkVehicle')->name('admin.maintenance.checkVehicle');
        Route::post('/maintenance/check-maintenance','checkMaintenance')->name('admin.maintenance.checkMaintenance');
    });


    Route::controller(App\Http\Controllers\InvoiceController::class)->group(function(){
        Route::get('/invoice', 'index')->name('admin.invoice.index');
        Route::get('/invoice/create', 'create')->name('admin.invoice.create');
        Route::post('/invoice/create','store')->name('admin.invoice.store');
        Route::get('/invoice/{id}', 'generate')->name('admin.invoice.generate');
        Route::get('/invoice/edit/{id}', 'edit')->name('admin.invoice.edit');
        Route::put('/invoice/edit/{id}', 'update')->name('admin.invoice.update');
        Route::delete('/invoice/delete/{id}', 'destroy')->name('admin.invoice.destroy');
    });

    Route::controller(App\Http\Controllers\RolesController::class)->group(function() {
        Route::get('/roles', 'index')->name('admin.roles.index');
        Route::get('/roles/create', 'create')->name('admin.roles.create');
        Route::post('/roles/create','store')->name('admin.roles.store');
        Route::get('/roles/{id}', 'edit')->name('admin.roles.edit');
        Route::put('/roles/{id}', 'update')->name('admin.roles.update');
        Route::delete('/roles/delete/{id}', 'destroy')->name('admin.roles.destroy');
    });

});
