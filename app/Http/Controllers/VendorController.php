<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Session;
class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::get();
        return view('vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */

     public function checkGst(Request $request)
     {
         // Check if the GST number already exists in the database
         $gstExists = Vendor::where('vendor_gst', $request->value)->exists();

         // Return response
         return response()->json([
             'exists' => $gstExists,
             'message' => $gstExists ? 'GST number already exists.' : '',
         ]);
     }

    public function create()
    {
        return view('vendor.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new Vendor();
        $add->name = $request->post('name');
        $add->email = $request->post('email');
        $add->phone_number = $request->post('phone_number');
        $add->address = $request->post('address');
        $add->vendor_gst = $request->post('vendor_gst');
        $add->save();

        Session::flash('success','Vendor saved successfully');
        return redirect()->route('admin.vendor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor, $id)
    {
        $data = Vendor::find($id);
        return view('vendor.show', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor, $id)
    {
        $data = Vendor::find($id);
        return view('vendor.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor, $id)
    {
        $update = Vendor::find($id);
        $update->name = $request->post('name');
        $update->email = $request->post('email');
        $update->phone_number = $request->post('phone_number');
        $update->address = $request->post('address');
        $update->vendor_gst = $request->post('vendor_gst') ?? $update->vendor_gst;
        $update->save();

        Session::flash('success','Vendor updated successfully');
        return redirect()->route('admin.vendor.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor, $id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();

        $msg = "Vendor deleted successfully";
        return response()->json($msg);
        //
    }
}
