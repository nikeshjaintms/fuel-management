<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Session;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::get();
        return view('drivers.index', compact('drivers'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drivers.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new Driver();
        $add->driver_name = $request->post('driver_name');
        $add->save();
        Session::flash('success', 'Driver added successfully');
        return redirect()->route('admin.driver.index');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver, $id)
    {
        $data = Driver::find($id);
        return view('drivers.show', compact('data'));

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver, $id)
    {
        $data = Driver::find($id);
        return view('drivers.edit', compact('data'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver, $id)
    {
        $data = Driver::find($id);
        $data->driver_name = $request->post('driver_name');
        $data->save();
        Session::flash('success', 'Driver updated successfully');
        return redirect()->route('admin.driver.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver, $id)
    {
        $data = Driver::find($id);
        $data->delete();
        $msg = "Driver deleted successfully";
        return response()->json($msg);
        //
    }
}
