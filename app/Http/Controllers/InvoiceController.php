<?php

namespace App\Http\Controllers;

use App\Models\ContractVehicle;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Invoice_vehicle;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::join('contracts', 'invoices.contract_id', '=', 'contracts.id')
            ->join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
            ->select('invoices.*', 'contracts.contract_no', 'customer_masterdatas.customer_name')
            ->orderBy('invoices.id', 'desc')
            ->get();
        // dd($invoices);
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();

        return view('invoice.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $add = new Invoice();
        $add->contract_id = $request->post('contract_id');
        $add->invoice_no = $request->post('invoice_no');
        $add->invoice_date = $request->post('invoice_date');
        $add->total_km = $request->post('total_km');
        $add->diesel_diff_rate = $request->post('diesel_diff_rate');
        $add->diesel_cost = $request->post('diesel_cost');
        $add->grand_subtotal = $request->post('grand_subtotal');
        $add->tax_type = $request->post('tax_type');
        $add->tax = $request->post('tax');
        $add->tax_amount = $request->post('tax_amount');
        $add->total_amount = $request->post('total_amount');
        $add->status = 'pending';
        $add->save();

        $invoice_id = $add->id;

        for ($i = 0; $i < count($request->vehicle_id); $i++) {
            Invoice_vehicle::create([
                'invoice_id' => $invoice_id,
                'vehicle_id' => $request->vehicle_id[$i] ?? null,
                'extra_km_drive' => $request->extra_km_drive[$i] ?? 0,
                'km_drive' => $request->km_drive[$i] ?? 0,
                'total_extra_km_amount' => $request->total_extra_km_amount[$i] ?? 0,
                'overtime' => $request->overtime[$i] ?? 0,
                'overtime_amount' => $request->overtime_amount[$i] ?? 0,
            ]);
        }
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice, $id)
    {
        $invoices = Invoice::join('contracts', 'invoices.contract_id', '=', 'contracts.id')
            ->join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
            ->select('invoices.*', 'contracts.contract_no', 'customer_masterdatas.customer_name')
            ->find($id);
        $invoice_vehicles = Invoice_vehicle::leftjoin('vehicles', 'invoice_vehicle.vehicle_id', '=', 'vehicles.id')
            ->select('invoice_vehicle.*', 'vehicles.vehicle_no')
            ->where('invoice_vehicle.invoice_id', $id)
            ->get();

        $contract_vehicles = ContractVehicle::where('contract_id', $invoices->contract_id)->get();
        // dd([$invoices, $invoice_vehicles, $contract_vehicles]);
        return view('invoice.show', compact('invoices', 'invoice_vehicles', 'contract_vehicles'));
    }

    public function cancel($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->status == 'cancelled') {
            return response()->json(['success' => false, 'message' => 'Invoice is already cancelled.']);
        }

        $invoice->status = 'cancelled';
        $invoice->save();

        return response()->json(['success' => true, 'message' => 'Invoice cancelled successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice, $id)
    {
        $customers = Customer::get();
        $invoices = Invoice::join('contracts', 'invoices.contract_id', '=', 'contracts.id')
        ->join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
        ->select('invoices.*', 'contracts.contract_no', 'customer_masterdatas.customer_name')
        ->find($id);
        $invoice_vehicles = Invoice_vehicle::leftjoin('vehicles', 'invoice_vehicle.vehicle_id', '=', 'vehicles.id')
        ->select('invoice_vehicle.*', 'vehicles.vehicle_no')
        ->where('invoice_id', $id)->get();
        $contract_vehicles = ContractVehicle::where('contract_id', $invoices->contract_id)->get();

        return view('invoice.edit', compact('customers', 'invoices', 'invoice_vehicles','contract_vehicles'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->total_km = $request->post('total_km');
        $invoice->diesel_diff_rate = $request->post('diesel_diff_rate');
        $invoice->diesel_cost = $request->post('diesel_cost');
        $invoice->grand_subtotal = $request->post('grand_subtotal');
        $invoice->tax_type = $request->post('tax_type');
        $invoice->tax = $request->post('tax');
        $invoice->tax_amount = $request->post('tax_amount');
        $invoice->total_amount = $request->post('total_amount');
        
        $invoice->save();


          // Store vehicle IDs to track which ones were updated/added
        $updatedVehicleIds = [];

        if ($request->has('vehicles')) {
            foreach ($request->vehicles as $vehicle) {
                $invoiceVehicle = Invoice_vehicle::where('invoice_id', $invoice->id)
                    ->where('vehicle_id', $vehicle['vehicle_id'])
                    ->first();

                if ($invoiceVehicle) {
                    // Update existing record
                    $invoiceVehicle->update([
                        'rate' => $vehicle['rate'],
                        'extra_km_drive' => $vehicle['extra_km_drive'],
                        'extra_km_rate' => $vehicle['extra_km_rate'],
                        'total_extra_km_amount' => $vehicle['total_extra_km_amount'],
                        'overtime' => $vehicle['overtime'],
                        'rate_per_hour' => $vehicle['rate_per_hour'],
                        'overtime_amount' => $vehicle['overtime_amount'],
                    ]);
                } else {
                    // Create new record if not exists
                    $invoiceVehicle = Invoice_vehicle::create([
                        'invoice_id' => $invoice->id,
                        'vehicle_id' => $vehicle['vehicle_id'],
                        'rate' => $vehicle['rate'],
                        'extra_km_drive' => $vehicle['extra_km_drive'],
                        'extra_km_rate' => $vehicle['extra_km_rate'],
                        'total_extra_km_amount' => $vehicle['total_extra_km_amount'],
                        'overtime' => $vehicle['overtime'],
                        'rate_per_hour' => $vehicle['rate_per_hour'],
                        'overtime_amount' => $vehicle['overtime_amount'],
                    ]);
                }

                $updatedVehicleIds[] = $invoiceVehicle->id;
            }
        }

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice, $id)
    {
        //
    }
}
