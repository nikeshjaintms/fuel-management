<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\FuelFilling;
use App\Models\Vehicles;
use App\Models\Driver;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;


class FuelFillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:fuel-filling-list|fuel-filling-create|fuel-filling-edit|fuel-filling-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:fuel-filling-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:fuel-filling-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:fuel-filling-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $vehicles = Vehicles::get();
        $customers = Customer::get();
        $fuelFillings = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
            ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
            ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
            ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name')
            ->orderBy('fuel_fillings.id', 'desc')
            ->get();
        return view('fuel_filling.index', compact(['fuelFillings', 'vehicles', 'customers']));

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicles::get();
        $drivers = Driver::get();
        $customers = Customer::get();
        return view('fuel_filling.create', compact(['vehicles', 'drivers', 'customers']));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fuelFilling = FuelFilling::where('vehicle_id', $request->vehicle_id)->orderBy('id', 'desc')->first();
        // dd($fuelFilling);
        if ($fuelFilling) {
            $kilometer = $fuelFilling->kilometers;
            $kilometers = $request->kilometers;
            $average =  $kilometer - $kilometers / $request->quantity;
        } else {
            $kilometers = $request->kilometers;
            $average = $kilometers / $request->quantity;
        }


        // dd($data);
        // dd($average);
        // dd($request->all());
        $add = new FuelFilling();
        $add->create([
            'vehicle_id' => $request->post('vehicle_id'),
            'driver_id' => $request->post('driver_id'),
            'customer_id' => $request->post('customer_id'),
            'filling_date' => $request->post('filling_date'),
            'nozzle_no' => $request->post('nozzle_no'),
            'quantity' => $request->post('quantity'),
            'kilometers' => $request->post('kilometers'),
            'average_fuel_consumption' => $average ?? '0',
        ]);

        $msg = "Fuel Filling added successfully";
        Session::flash('success', $msg);
        return redirect()->route('admin.fuel_filling.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelFilling $fuelFilling, $id)
    {
        $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
            ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
            ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
            ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name')->find($id);

        return view('fuel_filling.show', compact(['data']));
        //
    }
    //     public function genratePDF(){


    //         $data = FuelFilling::join('vehicles','fuel_fillings.vehicle_id','=','vehicles.id')
    //             ->join('drivers','fuel_fillings.driver_id','=','drivers.id')
    //             ->join('customer_masterdatas','fuel_fillings.customer_id','=','customer_masterdatas.id')
    //             ->select('fuel_fillings.*','vehicles.vehicle_no','drivers.driver_name','customer_masterdatas.customer_name','vehicles.average')->get();

    //         $html = "<style>
    //     table {
    //         border-collapse: collapse;
    //         width: 100%;
    //     }
    //     th, td {
    //         border: 1px solid black;
    //         padding: 8px;
    //         text-align: left;
    //     }
    //     th {
    //         background-color: #f2f2f2;
    //     }
    // </style>".view('fuel_filling.pdf', compact('data'))->render();

    //         $mpdf = new Mpdf();
    //         $mpdf->WriteHTML($html);

    //         return $mpdf->Output('fuel_filling.pdf','I');

    //     }

    public function generatePDF()
    {
        // Fetch data with joins
        $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
            ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
            ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
            ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')->get();

        // Load the Blade view
        $pdf = Pdf::loadView('fuel_filling.pdf', compact('data'));

        // Return PDF as inline display
        return $pdf->stream('fuel_filling.pdf');
    }

    public function custompdf(Request $request)
    {

        $vehicle_no = $request->vehicle_no ?? NULL;
        $customer_id = $request->customer_id ?? NULL;
        $start_date = $request->start_date ?? NULL;
        $end_date = $request->end_date ?? Carbon::today();
        $today = Carbon::today();

        if ($vehicle_no && $start_date && $end_date && $customer_id) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('vehicles.vehicle_no', $vehicle_no)
                ->whereBetween('fuel_fillings.filling_date', [$start_date, $end_date])
                ->get();
        } elseif ($vehicle_no && $start_date && $end_date) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('vehicles.vehicle_no', $vehicle_no)
                ->where('fuel_fillings.filling_date', '>=', $start_date)
                ->where('fuel_fillings.filling_date', '<=', $end_date)
                ->get();
        } elseif ($customer_id && $start_date && $end_date) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('customer_masterdatas.id', $customer_id)
                ->where('fuel_fillings.filling_date', '>=', $start_date)
                ->where('fuel_fillings.filling_date', '<=', $end_date)
                ->get();
        } elseif ($vehicle_no && $customer_id) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('vehicles.vehicle_no', $vehicle_no)
                ->get();
        } elseif ($vehicle_no && $start_date) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('vehicles.vehicle_no', $vehicle_no)
                ->where('fuel_fillings.filling_date', $start_date)
                ->get();
        } elseif ($customer_id && $start_date) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('customer_masterdatas.id', $customer_id)
                ->where('fuel_fillings.filling_date', $start_date)
                ->get();
        } elseif ($vehicle_no) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('vehicles.vehicle_no', $vehicle_no)
                ->get();
        } elseif ($customer_id) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('customer_masterdatas.id', $customer_id)
                ->get();
        } elseif ($start_date && $end_date) {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->whereBetween('fuel_fillings.filling_date', [$start_date, $end_date])
                ->get();
        } else {
            $data = FuelFilling::join('vehicles', 'fuel_fillings.vehicle_id', '=', 'vehicles.id')
                ->join('drivers', 'fuel_fillings.driver_id', '=', 'drivers.id')
                ->join('customer_masterdatas', 'fuel_fillings.customer_id', '=', 'customer_masterdatas.id')
                ->select('fuel_fillings.*', 'vehicles.vehicle_no', 'drivers.driver_name', 'customer_masterdatas.customer_name', 'vehicles.average')
                ->where('fuel_fillings.filling_date', '<=', $today)
                ->get();
        }

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Not Found');
        } else {
            $pdf = Pdf::loadView('fuel_filling.pdf', compact('data'))
            ->setPaper('A4', 'landscape'); // Set paper size and orientation

        return $pdf->stream('fuel_filling.pdf');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelFilling $fuelFilling, $id)
    {
        $fuelFilling = FuelFilling::find($id);
        $vehicles = Vehicles::get();
        $drivers = Driver::get();
        $customers = Customer::get();
        return view('fuel_filling.edit', compact(['fuelFilling', 'vehicles', 'drivers', 'customers']));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelFilling $fuelFilling, $id)
    {
        $fuelFilling = FuelFilling::find($id);
        $fuelFillings = FuelFilling::where('vehicle_id', $request->vehicle_id)->orderBy('id', 'desc')->first();
        if ($fuelFillings) {
            $kilometer = $fuelFillings->kilometers;
            $kilometers = $request->kilometers;
            $average =   $kilometer - $kilometers / $request->quantity;
        } else {

            $average = $request->kilometers /  $request->quantity;
        }

        $fuelFilling->update([
            'vehicle_id' => $request->post('vehicle_id'),
            'driver_id' => $request->post('driver_id'),
            'customer_id' => $request->post('customer_id'),
            'filling_date' => $request->post('filling_date'),
            'nozzle_no' => $request->post('nozzle_no'),
            'quantity' => $request->post('quantity'),
            'kilometers' => $request->post('kilometers'),
            'average_fuel_consumption' =>  $average,
        ]);
        Session::flash('success', "Fuel Filling updated successfully");
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
