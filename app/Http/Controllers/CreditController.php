<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\CreditItem;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credits = Credit::join('customer_masterdatas','credits.customer_id','=','customer_masterdatas.id')
        ->join('invoices','credits.invoice_id','=','invoices.id')
        ->select('credits.*','customer_masterdatas.customer_name','customer_masterdatas.customer_address','customer_masterdatas.customer_gst','invoices.invoice_no')
        ->orderBy('credits.id', 'desc')
        ->get();

        // dd($credits);
        return view('credits.index', compact('credits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();
        $invoice = Invoice::get();
        return view('credits.create', compact('customers', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new Credit();
        $add->customer_id = $request->post('customer_id');
        $add->invoice_id = $request->post('invoice_id');
        $add->credit_number = $request->post('credit_number');
        $add->credit_Date = $request->post('credit_date');
        $add->subtotal_amount = $request->post('subtotal_amount');
        $add->tax_type = $request->post('tax_type');
        $add->tax = $request->post('tax');
        $add->tax_amount = $request->post('tax_amount');
        $add->total_amount = $request->post('total_amount');
        $add->save();

        $items = $request->post('item');
        if ($items) {
            foreach ($items as $index => $item) {
                CreditItem::create([
                    'credit_id' => $add->id,
                    'item' => $item,
                    'hsn_sac' => $request->post('hsn_sac')[$index] ?? null,
                    'quantity' => $request->post('quantity')[$index],
                    'rate' => $request->post('rate')[$index],
                    'unit' => $request->post('unit')[$index] ?? null,
                    'amount' => $request->post('amount')[$index],
                ]);
            }
        }


        return redirect()->route('admin.credits.index')->with('success', 'Credit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Credit $credit, $id)
    {
        $credits = Credit::join('customer_masterdatas','credits.customer_id','=','customer_masterdatas.id')
        ->join('invoices','credits.invoice_id','=','invoices.id')
        ->select('credits.*','customer_masterdatas.customer_name','customer_masterdatas.customer_address','customer_masterdatas.customer_gst','invoices.invoice_no')
        ->orderBy('credits.id', 'desc')
        ->find($id);

        $credits_items = CreditItem::where('credit_id', $id)->get();
        // dd([$credits, $credits_items]);
        return view('credits.show', compact('credits', 'credits_items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Credit $credit, $id)
    {
        $credits = Credit::join('customer_masterdatas','credits.customer_id','=','customer_masterdatas.id')
        ->join('invoices','credits.invoice_id','=','invoices.id')
        ->select('credits.*','customer_masterdatas.customer_name','customer_masterdatas.customer_address','customer_masterdatas.customer_gst','invoices.invoice_no')
        ->orderBy('credits.id', 'desc')
        ->find($id);

        $credits_items = CreditItem::where('credit_id', $id)->get();


        return view('credits.edit', compact('credits', 'credits_items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Credit $credit, $id)
    {
        $update = Credit::find($id);
        $update->subtotal_amount = $request->post('subtotal_amount');
        $update->tax_type = $request->post('tax_type');
        $update->tax = $request->post('tax');
        $update->tax_amount = $request->post('tax_amount');
        $update->total_amount = $request->post('total_amount');
        $update->save();
        
        if ($request->has('item')) {
            foreach ($request->post('item') as $index => $item) {
                $creditItemId = $request->post('credit_item_id')[$index] ?? null;

                if ($creditItemId) {
                    // Update existing item
                    $creditItem = CreditItem::find($creditItemId);
                    if ($creditItem) {
                        $creditItem->update([
                            'item' => $item,
                            'hsn_sac' => $request->post('hsn_sac')[$index] ?? null,
                            'quantity' => $request->post('quantity')[$index],
                            'rate' => $request->post('rate')[$index],
                            'unit' => $request->post('unit')[$index] ?? null,
                            'amount' => $request->post('amount')[$index],
                        ]);
                    }
                } else {
                    // Create new item if no ID is found
                    CreditItem::create([
                        'credit_id' => $update->id,
                        'item' => $item,
                        'hsn_sac' => $request->post('hsn_sac')[$index] ?? null,
                        'quantity' => $request->post('quantity')[$index],
                        'rate' => $request->post('rate')[$index],
                        'unit' => $request->post('unit')[$index] ?? null,
                        'amount' => $request->post('amount')[$index],
                    ]);
                }
            }
        }

        return redirect()->route('admin.credits.index')->with('success', 'Credit updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credit $credit,$id)
    {
        $credit = Credit::find($id);
        $credit_items = CreditItem::where('credit_id', $id)->get();
        foreach ($credit_items as $credit_item) {
            $credit_item->delete();
        }
        $credit->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Credit deleted successfully.',
        ]);
    }
}
