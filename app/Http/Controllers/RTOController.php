<?php

namespace App\Http\Controllers;

use App\Models\RTO;
use App\Models\RTOTaxPayment;
use App\Models\Vehicles;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RTOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $rtos = RTO::join('vehicles', 'r_t_o_s.vehicle_id', '=', 'vehicles.id')
        ->leftjoin('rto_tax_payment', 'r_t_o_s.id', '=', 'rto_tax_payment.rto_id')
        ->select('r_t_o_s.id', 'r_t_o_s.policy_no', 'vehicles.vehicle_no', 'rto_tax_payment.status', 'rto_tax_payment.month', 'rto_tax_payment.year')
        ->groupBy('r_t_o_s.id', 'r_t_o_s.policy_no', 'vehicles.vehicle_no','rto_tax_payment.status', 'rto_tax_payment.month', 'rto_tax_payment.year')
        ->get();
    return view('rto.index', compact('rtos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicles::get();
        return view('rto.create',compact(['vehicles']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new RTO();
        $add->create([
            'vehicle_id' => $request->post('vehicle_id'),
            'policy_no' => $request->post('policy_no'),
            'policy_expiry_date' => $request->post('policy_expiry_date'),
            'fitness_expiry_date' => $request->post('fitness_expiry_date'),
            'puc_expiry_date' => $request->post('puc_expiry_date'),
        ]);

        return redirect()->route('admin.rto.index')->with('success', 'RTO record added successfully');
        //
    }

    public function paytax(Request $request, $id){
        $rto = RTO::find($id);

        $paytax = new RTOTaxPayment();
        $paytax->rto_id = $rto->id;
        $paytax->vehicle_id =  $rto->vehicle_id;
        $paytax->month = Carbon::now()->format('M');
        $paytax->year = Carbon::now()->format('Y');
        $paytax->payment_date = Carbon::now()->format('Y-m-d');
        $paytax->status = "Paid";
        $paytax->save();

        return redirect()->route('admin.rto.index')->with('success', 'Tax payment record added successfully');

    }
    public function checkVehicle(Request $request)
    {
        $exists = RTO::where('vehicle_id', $request->vehicle_id)->exists();

        return response()->json(['exists' => $exists]); // Return false if exists (to show error), true otherwise
    }

    /**
     * Display the specified resource.
     */
    public function show(RTO $rTO, $id)
    {
        $data = RTO::join('vehicles', 'r_T_o_s.vehicle_id', '=','vehicles.id')
        ->leftjoin('rto_tax_payment', 'r_T_o_s.id', '=','rto_tax_payment.rto_id')
        ->select('r_t_o_s.*','vehicles.vehicle_no','rto_tax_payment.status', 'rto_tax_payment.month', 'rto_tax_payment.year')
        ->where('r_t_o_s.id',$id)
        ->first();

        return view('rto.show', compact('data'));
    }


    public function edit(RTO $rTO,$id)
    {
        $vehicles = Vehicles::get();
        $rto = RTO::find($id);
        return view('rto.edit', compact(['rto', 'vehicles']));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RTO $rTO, $id)
    {
        // dd($request->method());

        $update = RTO::find($id);
        $update->update([
            'vehicle_id' => $request->post('vehicle_id'),
            'policy_no' => $request->post('policy_no'),
            'policy_expiry_date' => $request->post('policy_expiry_date'),
            'fitness_expiry_date' => $request->post('fitness_expiry_date'),
            'puc_expiry_date' => $request->post('puc_expiry_date'),
            'road_tax_expiry_date' => $request->post('road_tax_expiry_date')
        ]);
        return redirect()->route('admin.rto.index')->with('success', 'RTO record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RTO $rTO ,$id)
    {
        $delete = RTO::find($id);
        $delete->delete();

        $msg = "Deleted successfully";
        return response()->json($msg);
    }
}
