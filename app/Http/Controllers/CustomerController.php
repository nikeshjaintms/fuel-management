<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customer_info.index', compact('customers'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customer_types = CustomerType::get();
        return view('customer_info.create', compact(['customer_types']));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new Customer();
        $add->create([
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_type' => $request->customer_type,
            'customer_mobile_no' => $request->customer_mobile_no,
            'customer_email' => $request->customer_email,
        ]);

        Session::flash('success', 'Customer added successfully');
        return redirect()->route('admin.customer_info.index');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $Customer, $id)
    {
        $data = Customer::find($id);
        return view('customer_info.show', compact('data'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $Customer, $id)
    {
        $data = Customer::find($id);
        return view('customer_info.edit', compact(['data']));
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $Customer,$id)
    {
        $update = Customer::find($id);
        $update->update([
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_type' => $request->customer_type,
            'customer_mobile_no' => $request->customer_mobile_no,
            'customer_email' => $request->customer_email,
        ]);
        Session::flash('success', 'Customer updated successfully');
        return redirect()->route('admin.customer_info.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $Customer, $id)
    {
        $delete = Customer::find($id);
        $delete->delete();
        $msg = "Deleted Successfully";
        return response()->json($msg);

        //
    }
}
