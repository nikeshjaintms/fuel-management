<?php

namespace App\Http\Controllers;

use App\Models\Masterdata;
use App\Models\Vehicles;
use App\Models\Customer;
use Illuminate\Http\Request;

class MasterdataController extends Controller
{
    public function index()
    {
        $owners = Masterdata::join('vehicles','masterdatas.vehicle_id','=','vehicles.id')
        ->join('customer_masterdatas','masterdatas.customer_id','=','customer_masterdatas.id')
        ->select('masterdatas.*','vehicles.vehicle_no','customer_masterdatas.customer_name')
        ->get();
        return view('owner.index', compact(['owners']));
    }


    public function create()
    {
        $vehicles = Vehicles::all();
        $customers = Customer::all();
        return view('owner.create', compact(['vehicles', 'customers']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new Masterdata();
        $add->vehicle_id = $request->post('vehicle_id');
        $add->customer_id = $request->post('customer_id');
        $add->owner_name = $request->post('owner_name');
        $add->type = $request->post('type');
        $add->asset_make_model = $request->post('asset_make_model');
        $add->segment = $request->post('segment');
        $add->model = $request->post('model');
        $add->body = $request->post('body');
        $add->yom = $request->post('yom');
        $add->finance_by = $request->post('finance_by');
        $add->loan_amount = $request->post('loan_amount');
        $add->loan_account = $request->post('loan_account');
        $add->emi_amount = $request->post('emi_amount');
        $add->total_emi = $request->post('total_emi');
        $add->emi_paid = $request->post('emi_paid');
        $add->pending_emi = $request->post('pending_emi');
        $add->start_date = $request->post('start_date');
        $add->end_date = $request->post('end_date');
        $add->rate_of_interest = $request->post('rate_of_interest');
        $add->save();

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Masterdata $masterdata, $id)
    {
        $data = Masterdata::join('vehicles','masterdatas.vehicle_id','=','vehicles.id')
        ->join('customer_masterdatas','masterdatas.customer_id','=','customer_masterdatas.id')
        ->select('masterdatas.*','vehicles.vehicle_no','customer_masterdatas.customer_name')
        ->where('masterdatas.id',$id)
        ->first();
        return view('owner.show', compact(['data']));

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Masterdata $masterdata, $id)
    {
        $vehicles = Vehicles::all();
        $customers = Customer::all();
        $data = Masterdata::find($id);
        return view('owner.edit', compact(['vehicles', 'customers', 'data']));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Masterdata $masterdata, $id)
    {
        $update = Masterdata::find($id);
        $update->vehicle_id = $request->post('vehicle_id');
        $update->customer_id = $request->post('customer_id');
        $update->owner_name = $request->post('owner_name');
        $update->type = $request->post('type');
        $update->asset_make_model = $request->post('asset_make_model');
        $update->segment = $request->post('segment');
        $update->model = $request->post('model');
        $update->body = $request->post('body');
        $update->yom = $request->post('yom');
        $update->finance_by = $request->post('finance_by');
        $update->loan_amount = $request->post('loan_amount');
        $update->loan_account = $request->post('loan_account');
        $update->emi_amount = $request->post('emi_amount');
        $update->total_emi = $request->post('total_emi');
        $update->emi_paid = $request->post('emi_paid');
        $update->pending_emi = $request->post('pending_emi');
        $update->start_date = $request->post('start_date');
        $update->end_date = $request->post('end_date');
        $update->rate_of_interest = $request->post('rate_of_interest');
        $update->save();

        return redirect()->route('admin.owner.index')->with('success','Updated Successfully');


        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masterdata $masterdata ,$id)
    {
        $delete = Masterdata::find($id);
        $delete->delete();
        $msg = "Deleted successfully";
        return response()->json($msg);
        //
    }
}
