<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Vehicles;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotations = Quotation::join('customer_masterdatas', 'quotations.customer_id', '=', 'customer_masterdatas.id')
            ->select('quotations.*', 'customer_masterdatas.customer_name')
            ->orderBy('quotations.id', 'desc')->get();

        return view('quotation.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();

        return view('quotation.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $add = new Quotation();
        $add->customer_id = $request->post('customer_id');
        $add->quotation_date = $request->post('quotation_date');
        $add->gst_charge = $request->post('gst_charge');
        $add->price_variation = $request->post('price_variation');
        $add->present_fuel_rate = $request->post('present_fuel_rate');
        $add->save();

        $quotation_id = $add->id;

        if ($request->has('type_of_vehicle')) {
            foreach ($request->get('type_of_vehicle') as $key => $vehicleType) {
                QuotationItem::create([
                    'quotation_id' => $quotation_id,
                    'type_of_vehicle' => $vehicleType,
                    'km' => $request->get('km')[$key],
                    'rate' => $request->get('rate')[$key],
                    'extra_km_rate' => $request->get('extra_km_rate')[$key],
                    'over_time_rate' => $request->get('over_time_rate')[$key],
                    'average' => $request->post('average')[$key],

                ]);
            }
        }


        return redirect()->route('quotations.success', ['id' =>$quotation_id])->with('success', 'Quotation added successfully');
    }

    public function printQuotation($id)
    {
        $data = Quotation::join('customer_masterdatas', 'quotations.customer_id', '=', 'customer_masterdatas.id')
            ->select('quotations.*', 'customer_masterdatas.customer_name', 'customer_masterdatas.customer_address')
            ->where('quotations.id', $id)->first();

        $quotation_items = QuotationItem::where('quotation_id', $id)->get();
        $pdf = Pdf::loadView('quotation.pdf', compact('data', 'quotation_items'));

        return $pdf->stream('quotation-' . $id . '.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation, $id)
    {
        $data = Quotation::join('customer_masterdatas', 'quotations.customer_id', '=', 'customer_masterdatas.id')
            ->select('quotations.*', 'customer_masterdatas.customer_name',)
            ->where('quotations.id', $id)->first();

        $quotation_items = QuotationItem::where('quotation_id', $id)->get();


        return view('quotation.show', compact('data', 'quotation_items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation, $id)
    {
        $data = Quotation::join('customer_masterdatas', 'quotations.customer_id', '=', 'customer_masterdatas.id')
            ->select('quotations.*', 'customer_masterdatas.customer_name', 'customer_masterdatas.customer_gst')
            ->where('quotations.id', $id)->first();

        $quotation_items = QuotationItem::where('quotation_id', $id)->get();

        return view('quotation.edit', compact('data', 'quotation_items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation, $id)
    {
        $quotation = Quotation::find($id);
        $quotation->gst_charge = $request->post('gst_charge');
        $quotation->price_variation = $request->post('price_variation');
        $quotation->present_fuel_rate = $request->post('present_fuel_rate');
        $quotation->save();

        $existingItemIds = QuotationItem::where('quotation_id', $id)->pluck('id')->toArray();

        // Collect request item IDs
        $requestItemIds = $request->has('item_id') ? $request->get('item_id') : [];

        // Identify items to delete (those in DB but not in the request)
        $itemsToDelete = array_diff($existingItemIds, $requestItemIds);
        QuotationItem::whereIn('id', $itemsToDelete)->delete();

        // Process request items (update existing or create new)
        if ($request->has('type_of_vehicle')) {
            foreach ($request->get('type_of_vehicle') as $key => $vehicleType) {
                $itemId = $request->get('item_id')[$key] ?? null;

                if ($itemId && in_array($itemId, $existingItemIds)) {
                    // Update existing item
                    QuotationItem::where('id', $itemId)->update([
                        'type_of_vehicle' => $vehicleType,
                        'km' => $request->get('km')[$key],
                        'rate' => $request->get('rate')[$key],
                        'extra_km_rate' => $request->get('extra_km_rate')[$key],
                        'over_time_rate' => $request->get('over_time_rate')[$key],
                        'average' => $request->get('average')[$key],

                    ]);
                } else {
                    // Create new item
                    QuotationItem::create([
                        'quotation_id' => $id,
                        'type_of_vehicle' => $vehicleType,
                        'km' => $request->get('km')[$key],
                        'rate' => $request->get('rate')[$key],
                        'extra_km_rate' => $request->get('extra_km_rate')[$key],
                        'over_time_rate' => $request->get('over_time_rate')[$key],
                        'average' => $request->get('average')[$key],

                    ]);
                }
            }
        }

        // Redirect with success message
        return redirect()->route('admin.quotations.index')->with('success', 'Quotation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation, $id)
    {
        $quotation = Quotation::find($id);

        if (!$quotation) {
            return redirect()->route('admin.quotation.index')->with('error', 'Quotation not found.');
        }

        // Delete related QuotationItems first
        QuotationItem::where('quotation_id', $id)->delete();

        // Delete the Quotation
        $quotation->delete();

        return response()->json(['status' => "success"]);
    }
}
