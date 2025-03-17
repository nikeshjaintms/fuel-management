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
    $rtos = RTOTaxPayment::join('vehicles', 'rto_tax_payment.vehicle_id', '=', 'vehicles.id')
    ->select('rto_tax_payment.*', 'vehicles.vehicle_no')
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
        $paytax = new RTOTaxPayment();
        $paytax->vehicle_id =  $request->vehicle_id;
        $paytax->month = Carbon::now()->format('M');
        $paytax->year = Carbon::now()->format('Y');
        $paytax->status = "Pending";
        $paytax->save();

        return redirect()->route('admin.rto.index')->with('success', 'RTO record added successfully');
        //
    }

    public function bulkPay(Request $request)
    {
        if (!$request->has('ids') || empty($request->ids)) {
            return response()->json(['success' => false, 'message' => 'No records selected.']);
        }

        // Check for already paid taxes
        $alreadyPaid = RTOTaxPayment::whereIn('id', $request->ids)->where('status', 'Paid')->count();
        if ($alreadyPaid == count($request->ids)) {
            return response()->json(['success' => false, 'message' => 'All selected taxes are already paid.']);
        }

        // Update status and set the payment_date to the current timestamp
        RTOTaxPayment::whereIn('id', $request->ids)->update([
            'status' => 'Paid',
            'payment_date' => now() // Stores the current date and time
        ]);

        return response()->json(['success' => true, 'message' => 'Taxes marked as paid successfully.']);
    }

    public function paytax(Request $request, $id){
        $rto = RTOTaxPayment::find($id);

        if($rto->status == "Paid"){
            Session::flash('error', 'Tax payment already made for this vehicle');
            return redirect()->route('admin.rto.index');
        }
        elseif($rto->month == Carbon::now()->format('M') && $rto->year ==  Carbon::now()->format('Y') && $rto->status != "Paid")
        {
            $rto->payment_date = Carbon::now()->format('Y-m-d');
            $rto->status = "Paid";
            $rto->save();
        }
        else{
            $paytax = new RTOTaxPayment();
            $paytax->vehicle_id =  $rto->vehicle_id;
            $paytax->month = Carbon::now()->format('M');
            $paytax->year = Carbon::now()->format('Y');
            $paytax->payment_date = Carbon::now()->format('Y-m-d');
            $paytax->status = "Paid";
            $paytax->save();
        }
        return redirect()->route('admin.rto.index')->with('success', 'Tax payment record added successfully');

    }
    public function checkVehicle(Request $request)
    {
        $exists = RTOTaxPayment::where('vehicle_id', $request->vehicle_id)
            ->where('month',Carbon::now()->format('M'))
            ->where('year',Carbon::now()->format('Y'))
            ->exists();

        return response()->json(['exists' => $exists]); // Return false if exists (to show error), true otherwise
    }

    /**
     * Display the specified resource.
     */
    public function show(RTO $rTO, $id)
    {

    }

    public function edit(RTO $rTO,$id)
    {
        $vehicles = Vehicles::get();
        $rto = RTOTaxPayment::find($id);
        return view('rto.edit', compact(['rto', 'vehicles']));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RTO $rTO, $id)
    {
        // dd($request->method());

        $update = RTOTaxPayment::find($id);
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
        $delete = RTOTaxPayment::find($id);
        $delete->delete();

        $msg = "Deleted successfully";
        return response()->json($msg);
    }
}
