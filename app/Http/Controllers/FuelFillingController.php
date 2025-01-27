<?php

namespace App\Http\Controllers;

use App\Models\FuelFilling;
use App\Models\Vehicles;
use App\Models\Driver;
use Illuminate\Http\Request;

class FuelFillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fuelFillings = FuelFilling::join('vehicles','fuel_fillings.vehicle_id','=','vehicles.id')
        ->join('drivers','fuel_fillings.driver_id','=','drivers.id')
        ->select('fuel_fillings.*','vehicles.vehicle_no','drivers.driver_name')
        ->get();
        return view('fuel_filling.index', compact('fuelFillings'));

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicles::get();
        $drivers = Driver::get();
        return view('fuel_filling.create',compact(['vehicles','drivers']));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new FuelFilling();
        $add->create([
            'vehicle_id' => $request->post('vehicle_id'),
            'driver_id' => $request->post('driver_id'),
            'filling_date' => $request->post('filling_date'),
            'quantity' => $request->post('quantity'),
            'kilometers' => $request->post('kilometers'),
            'average_fuel_consumption' => $request->post('average_fuel_consumption'),
        ]);

        $msg = "Fuel Filling added successfully";
        Session::flash('success', $msg);
        return redirect()->route('admin.fuel_fillings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelFilling $fuelFilling, $id)
    {
        $fuelFilling = FuelFilling::find($id)->join('vehicles','fuel_fillings.vehicle_id','=','vehicles.id')
            ->join('drivers','fuel_fillings.driver_id','=','drivers.id')
            ->select('fuel_fillings.*','vehicles.vehicle_no')->get();
        return view('fuel_filling.show', compact('fuelFilling'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelFilling $fuelFilling, $id)
    {
        $fuelFilling = FuelFilling::find($id);
        $vehicles = Vehicles::get();
        $drivers = Driver::get();
        return view('fuel_filling.edit', compact(['fuelFilling','vehicles','drivers']));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelFilling $fuelFilling, $id)
    {
        $fuelFilling = FuelFilling::find($id);
        $fuelFilling->update([
            'vehicle_id' => $request->post('vehicle_id'),
            'driver_id' => $request->post('driver_id'),
           'filling_date' => $request->post('filling_date'),
            'quantity' => $request->post('quantity'),
            'kilometers' => $request->post('kilometers'),
            'average_fuel_consumption' => $request->post('average_fuel_consumption'),
        ]);
        $msg = "Fuel Filling updated successfully";
        return redirect()->route('admin.fuel_filling.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelFilling $fuelFilling, $id)
    {
        $fuelFilling = FuelFilling::find($id);
        $fuelFilling->delete();
        $msg = "Fuel Filling deleted successfully";
        return response()->json($msg);

        //
    }
}
