<?php

namespace App\Http\Controllers;

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
        //
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
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
