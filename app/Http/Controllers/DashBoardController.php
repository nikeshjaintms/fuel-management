<?php

namespace App\Http\Controllers;

use App\Models\FuelFilling;
use App\Models\Vehicles;
use App\Models\Customer;
use App\Models\Driver;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function index(){

        $vehicle_count = Vehicles::count();
        $driver = Driver::count();
        $total_fuel_consumed = FuelFilling::sum('quantity');
        $customer_count = Customer::count();
        return view('index', compact('vehicle_count', 'driver','total_fuel_consumed','customer_count'));
    }

    public function getData()
    {
        $data = [
            'total_vehicles' => Vehicles::count(),
            'total_fuel' => FuelFilling::sum('quantity'),
            'total_customers' => Customer::count(),
            'total_drivers' => Driver::count(),
        ];
        return response()->json($data);
    }
    //
}
