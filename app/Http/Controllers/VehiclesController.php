<?php

namespace App\Http\Controllers;

use App\Models\Vehicles;
use Auth;
use Session;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        if (Auth::guard('admin')->check()) {
           return redirect()->route('index');
        } else {
            return redirect()->route('login');
        }

    }
    public function index()
    {
        $vehicles = Vehicles::get();
        return view('vehicle_info.index', compact('vehicles'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicle_info.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new Vehicles();
        $add->create([
            "vehicle_no" => $request->post('vehicle_no'),
            "vehicle_engine_no" => $request->post('vehicle_engine_no'),
            "vehicle_chassis_no" => $request->post('vehicle_chassis_no'),
            "vehicle_policy_no" => $request->post('vehicle_policy_no'),
            "vehicle_policy_expiry_date" => $request->post('vehicle_policy_expiry_date'),
            "vehicle_fitness_expiry_date" => $request->post('vehicle_fitness_expiry_date'),
            "vehicle_puc_expiry_date" => $request->post('vehicle_puc_expiry_date'),
        ]);

        Session::flash('success', 'Vehicle added successfully');
        return redirect()->route('admin.vehicles.index');

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicles $vehicles, $id)
    {
        $data = Vehicles::find($id);
        return view('vehicle_info.show', compact('data'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicles $vehicles , $id)
    {
        $vehicle = Vehicles::find($id);
        return view('vehicle_info.edit', compact('vehicle'));
        //
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicles $vehicles, $id)
    {
        $vehicle = Vehicles::find($id);
        $vehicle->vehicle_no = $request->post('vehicle_no');
        $vehicle->vehicle_engine_no = $request->post('vehicle_engine_no');
        $vehicle->vehicle_chassis_no = $request->post('vehicle_chassis_no');
        $vehicle->vehicle_policy_no = $request->post('vehicle_policy_no');
        $vehicle->vehicle_policy_expiry_date = $request->post('vehicle_policy_expiry_date');
        $vehicle->vehicle_fitness_expiry_date = $request->post('vehicle_fitness_expiry_date');
        $vehicle->vehicle_puc_expiry_date = $request->post('vehicle_puc_expiry_date');
        $vehicle->save();

        Session::flash('success', 'Vehicle updated successfully');
        return redirect()->route('admin.vehicles.index');

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicles $vehicles)
    {
        //
    }
}
