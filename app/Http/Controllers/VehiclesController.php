<?php

namespace App\Http\Controllers;

use App\Models\Vehicles;
use Auth;
use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

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
        $today = Carbon::today();
        $alerts = [];

        // Loop through tasks and check if the due_date is within 10 days
        foreach ($vehicles as $item) {
            $Policydate = Carbon::parse($item->vehicle_policy_expiry_date);
            $fitnessDate = Carbon::parse($item->vehicle_fitness_expiry_date);
            $PUCdate = Carbon::parse($item->vehicle_puc_expiry_date);

            // // dd($daysforpolicy);

            $itemVehicleNoOrChassisNo = $item->vehicle_no ?? $item->vehicle_chassis_no;

            if ($Policydate->diffInDays($today) <= 10 && $Policydate->isFuture()) {
                $alerts[] = "Expiry: " . $itemVehicleNoOrChassisNo . " Policy is due on " . $Policydate->toFormattedDateString();
            }
            
            if ($fitnessDate->diffInDays($today) <= 10 && $fitnessDate->isFuture()) {
                $alerts[] = "Expiry: " . $itemVehicleNoOrChassisNo . " Fitness is due on " . $fitnessDate->toFormattedDateString();
            }
            
            if ($PUCdate->diffInDays($today) <= 10 && $PUCdate->isFuture()) {
                $alerts[] = "Expiry: " . $itemVehicleNoOrChassisNo . " PUC is due on " . $PUCdate->toFormattedDateString();
            }
            
            // If there are any alerts, you can display them, for example:
           
            return view('vehicle_info.index', compact(['vehicles', 'alerts']));
        //
        }
    }

    public function check(Request $request)
    {
        $field = $request->input('field'); // This will either be 'vehicle_no' or 'vehicle_chassis_no'
        $value = $request->input('value');

        if (in_array($field, ['vehicle_no', 'vehicle_chassis_no'])) { // Allow only valid fields
            $exists = DB::table('vehicles')->where($field, $value)->exists();

            return response()->json([
                'exists' => $exists,
                'message' => $exists ? ucfirst(str_replace('_', ' ', $field)) . " already exists." : null,
            ]);
        }

        return response()->json(['error' => 'Invalid field'], 400);
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
    public function edit(Vehicles $vehicles, $id)
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
    public function destroy(Vehicles $vehicles, $id)
    {
        $vehicle = Vehicles::find($id);
        $vehicle->delete();
        $msg = "Vehicle deleted successfully";
        return response()->json($msg);
    }
}
