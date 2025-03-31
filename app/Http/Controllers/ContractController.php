<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractVehicle;
use App\Models\Customer;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Session;

class ContractController extends Controller
{
    public function getContracts(Request $request)
    {
        $contracts = Contract::where('customer_id', $request->customer_id)->orderBy('id','desc')->get();
        return response()->json($contracts);
    }

    public function getContractDetails(Request $request)
{
    $contract = Contract::where('id', $request->contract_id)->first();

    $vehicles = ContractVehicle::where('contract_id', $request->contract_id)
        ->join('vehicles', 'contract_vehicles.vehicle_id', '=', 'vehicles.id')
        ->select('vehicles.id', 'vehicles.vehicle_no', 'contract_vehicles.*')
        ->get();

    return response()->json([
        'contract' => $contract,
        'vehicles' => $vehicles
    ]);
}

    public function index()
    {
        $contracts = Contract::join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
            ->select('contracts.*', 'customer_masterdatas.customer_name as cname')
            ->get();
        return view('contract.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();
        $vehicles = Vehicles::get();

        return view('contract.create', compact('customers', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $add = new Contract();
        $add->customer_id = $request->post('customer_id');
        $add->contract_no = $request->post('contract_no');
        $add->contract_date = $request->post('contract_date');
        $add->save();

        foreach ($request['vehicle_id'] as $index => $vehicleId) {
            ContractVehicle::create([
                'contract_id' => $add->id,
                'vehicle_id' => $vehicleId[$index],
                'type' => $request['type'][$index],
                'min_km' => $request['min_km'][$index],
                'rate' => $request['rate'][$index],
                'extra_km_rate' => $request['extra_km_rate'][$index],
                'rate_per_hour' => $request['rate_per_hour'][$index],
            ]);
        }

        Session::flash('success', 'Vehicle Created Successfully');
        return redirect()->route('admin.contract.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Contract $contract, $id)
    {
        $data = Contract::join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
            ->select('contracts.*', 'customer_masterdatas.customer_name as cname')
            ->find($id);
        $vehicles = ContractVehicle::leftJoin('vehicles', 'contract_vehicles.vehicle_id', '=', 'vehicles.id')
            ->select('contract_vehicles.*', 'vehicles.vehicle_no')
            ->where('contract_vehicles.contract_id', $id)
            ->get();


        return view('contract.show', compact('data', 'vehicles'));
    }

    public function checkVehicleAvailability(Request $request)
{
    $vehicleId = $request->vehicle_id;
    $startDate = $request->start_date;

    // Check if the vehicle is booked within the given date range
    $isBooked = ContractVehicle::join('contracts', 'contract_vehicles.contract_id', '=', 'contracts.id')
        ->where('contract_vehicles.vehicle_id', $vehicleId)
        ->where('contracts.contract_Date', '!=', $startDate)
        ->exists();

    return response()->json([
        'status' => $isBooked ? 'error' : 'success',
        'message' => $isBooked ? 'This vehicle is already booked during the selected period.' : 'Vehicle is available.'
    ], $isBooked ? 400 : 200);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract, $id)
    {
        $data = Contract::join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
            ->select('contracts.*', 'customer_masterdatas.customer_name as cname')
            ->find($id);
        $cvehicles = ContractVehicle::where('contract_vehicles.contract_id', $id)
            ->get();
        $customers = Customer::get();
        $vehicles = Vehicles::get();
        return view('contract.edit', compact('data', 'cvehicles', 'customers', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract, $id)
    {
        $edit = Contract::find($id);
        if (!$edit) {
            return response()->json(['error' => 'Contract not found'], 404);
        }

        // Update contract details
        $edit->customer_id = $request->post('customer_id');
        $edit->contract_no = $request->post('contract_no');
        $edit->contract_date = $request->post('contract_date');
        $edit->save();

        // Get existing vehicle IDs
        $existingVehicles = ContractVehicle::where('contract_id', $id)->pluck('id', 'vehicle_id');

        $newVehicleIds = [];

        foreach ($request->vehicle_id as $index => $vehicleId) {
            $newVehicleIds[] = $vehicleId; // Track new vehicle IDs

            if (isset($existingVehicles[$vehicleId])) {
                // Update existing contract vehicle
                ContractVehicle::where('id', $existingVehicles[$vehicleId])->update([
                    'type' => $request->type[$index],
                    'min_km' => $request->min_km[$index],
                    'rate' => $request->rate[$index],
                    'extra_km_rate' => $request->extra_km_rate[$index],
                    'rate_per_hour' => $request->rate_per_hour[$index],
                ]);
            } else {
                // Insert new contract vehicle
                ContractVehicle::create([
                    'contract_id' => $id,
                    'vehicle_id' => $vehicleId,
                    'type' => $request->type[$index],
                    'min_km' => $request->min_km[$index],
                    'rate' => $request->rate[$index],
                    'extra_km_rate' => $request->extra_km_rate[$index],
                    'rate_per_hour' => $request->rate_per_hour[$index],
                ]);
            }
        }

        // Delete vehicles that are no longer associated
        ContractVehicle::where('contract_id', $id)->whereNotIn('vehicle_id', $newVehicleIds)->delete();
        Session::flash('success', 'Vehicle Updated Successfully');
        return redirect()->route('admin.contract.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract, $id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json(['error' => 'Contract not found'], 404);
        }

        // Delete related contract vehicles first
        ContractVehicle::where('contract_id', $id)->delete();

        // Now delete the contract
        $contract->delete();

        return response()->json(['success' => 'Contract deleted successfully!']);
    }
}
