<?php

namespace App\Http\Controllers;

use App\Models\Fitness;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Session;

class FitnessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fitnesses = Fitness::join('vehicles', 'fitnesses.vehicle_id','=','vehicles.id')
                ->select('fitnesses.*','vehicles.vehicle_no')
                ->get();
        return view('fitness.index', compact('fitnesses'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicles::get();
        return view('fitness.create', compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Fitness::create([
            'vehicle_id' => $request->vehicle_id,
            'expiry_date' => $request->expiry_date
        ]);
        Session::flash('success', 'Fitness record created successfully.');
        return redirect()->route('admin.fitness.index');
    }

    public function checkVehicle(Request $request)
    {
        $exists = Fitness::where('vehicle_id', $request->vehicle_id)->exists();

        return response()->json(['exists' => $exists]); // Return false if exists (to show error), true otherwise
    }
    /**
     * Display the specified resource.
     */
    public function show(Fitness $fitness)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fitness $fitness, $id)
    {
        $rto = Fitness::find($id);
        $vehicles = Vehicles::get();
        return view('fitness.edit', compact('rto','vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fitness $fitness, $id)
    {
        $rto = Fitness::find($id);
        $rto->vehicle_id = $request->vehicle_id;
        $rto->expiry_date = $request->expiry_date;
        $rto->save();
        Session::flash('success', 'Fitness record updated successfully.');
        return redirect()->route('admin.fitness.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fitness $fitness, $id)
    {
        $rto = Fitness::find($id);
        $rto->delete();
        $msg = 'Fitness record deleted successfully';

        return response()->json($msg);

    }
}
