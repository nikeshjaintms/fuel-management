<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Vehicles;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $installments = Installment::get();
        return view('installment.index', compact('installments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicle = Vehicles::get();
        return view('installment.create', compact('vehicle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Installment::create([
            'vehicle_id' => $request->post('vehicle_id'),
            'amount' => $request->post('amount'),
            'installment_date' => $request->post('installment_date'),
        ]);
        return redirect()->route('installment.index')->with('success', 'Installment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Installment $installment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installment $installment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Installment $installment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Installment $installment)
    {
        //
    }
}
