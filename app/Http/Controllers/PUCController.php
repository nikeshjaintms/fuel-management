<?php

namespace App\Http\Controllers;

use App\Models\PUC;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Session;
class PUCController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pucs = PUC::join('vehicles', 'p_u_c_s.vehicle_id', '=','vehicles.id')
            ->select('p_u_c_s.*','vehicles.vehicle_no')
            ->get();
        return view('puc.index', compact('pucs'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicles::get();
        return view('puc.create', compact('vehicles'));
    }

    public function checkVehicle(Request $request)
    {
        $exists = PUC::where('vehicle_id', $request->vehicle_id)->exists();

        return response()->json(['exists' => $exists]); // Return false if exists (to show error), true otherwise
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        PUC::create([
                'vehicle_id' => $request->vehicle_id,
                'expiry_date' => $request->expiry_date,
            ]);

        Session::flash('success','PUC has been created successfully');
        return redirect()->route('admin.puc.index');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PUC $pUC)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PUC $pUC, $id)
    {
        $rto = PUC::find($id);
        $vehicles = Vehicles::get();
        return view('puc.edit', compact('rto', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PUC $pUC, $id)
    {
        $rto = PUC::find($id);
        $rto->vehicle_id = $request->vehicle_id;
        $rto->expiry_date = $request->expiry_date;
        $rto->save();
        Session::flash('success','PUC has been updated successfully');
        return redirect()->route('admin.puc.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PUC $pUC, $id)
    {
        $puc = PUC::find($id);
        $puc->delete();
        $msg = "PUC has been deleted successfully";
        return response()->json($msg);
    }
}
