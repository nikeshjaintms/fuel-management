<?php

namespace App\Http\Controllers;

use App\Models\Vehicles;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VehiclesImport;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:vehicle-list|vehicle-create|vehicle-edit|vehicle-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:vehicle-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:vehicle-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vehicle-delete', ['only' => ['destroy']]);
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new VehiclesImport, $request->file('file'));
            return back()->with('success', 'Vehicles imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Handle validation failures
            return back()->withErrors($e->failures())->withInput();
        }
    }
    public function index()
    {
        $vehicles = Vehicles::get();
        $today = Carbon::today();
        $alerts = [];

        return view('vehicle_info.index', compact(['vehicles']));
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
            "average" => $request->post('average'),
            "road_tax_amount" => $request->post('road_tax_amount'),
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
        $vehicle->average = $request->post('average');
        $vehicle->road_tax_amount = $request->post('road_tax_amount');
        $vehicle->save();

        // Session::flash('success', 'Vehicle update successfully');
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle update successfully');


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
        Session::flash('success','Vehicle deleted successfully');

        return response()->json($msg);
    }
}
