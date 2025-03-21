<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:policy-list|policy-create|policy-edit|policy-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:policy-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:policy-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:policy-delete', ['only' => ['destroy']]);
        $this->middleware('permission:policy-payment', ['only' => ['updateEmiPaid']]);
    }
    public function index()
    {
        $polices = Policy::join('vehicles', 'policies.vehicle_id','=','vehicles.id')
                    ->select('policies.*','vehicles.vehicle_no')
                    ->get();

        return view('policy.index', compact('polices'));
    }
    public function checkPolicy(Request $request)
    {
        $exists = Policy::where('policy_no', $request->policy_no)->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicles::get();
        return view('policy.create', compact('vehicles'));
    }

    public function checkVehicle(Request $request)
    {
        $exists = Policy::where('vehicle_id', $request->vehicle_id)->exists();

        return response()->json(['exists' => $exists]); // Return false if exists (to show error), true otherwise
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Policy::create([
            'vehicle_id' => $request->post('vehicle_id'),
            'policy_no' => $request->post('policy_no'),
            'expiry_date' => $request->post('expiry_date'),
        ]);

        Session::flash('success', 'Policy created successfully');
        return redirect()->route('admin.policy.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Policy $policy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Policy $policy, $id)
    {
        $rto = Policy::find($id);
        $vehicles = Vehicles::get();
        return view('policy.edit', compact('rto', 'vehicles'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Policy $policy, $id)
    {
        $policy = Policy::find($id);
        $policy->vehicle_id = $request->post('vehicle_id');
        $policy->policy_no = $request->post('policy_no');
        $policy->expiry_date = $request->post('expiry_date');
        $policy->save();

        Session::flash('success', 'Policy updated successfully');
        return redirect()->route('admin.policy.index');

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Policy $policy, $id)
    {
        $policy = Policy::find($id);
        $policy->delete();
        $msg = "Policy deleted successfully";

        return response()->json($msg);
    }
}
