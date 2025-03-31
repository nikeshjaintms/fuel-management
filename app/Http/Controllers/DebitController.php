<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Debit;
use App\Models\DebitItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debits = Debit::join('customer_masterdatas','debits.customer_id','=','customer_masterdatas.id')
        ->join('invoices','debits.invoice_id','=','invoices.id')
        ->select('debits.*','customer_masterdatas.customer_name','customer_masterdatas.customer_address','customer_masterdatas.customer_gst','invoices.invoice_no')
        ->orderBy('debits.id', 'desc')
        ->get();

        return view('debits.index', compact('debits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();

        return view('debits.create', compact('customers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add = new Debit();
        $add->customer_id = $request->post('customer_id');
        $add->invoice_id = $request->post('invoice_id');
        $add->debit_number = $request->post('debit_number');
        $add->debit_date = $request->post('debit_date');
        $add->subtotal_amount = $request->post('subtotal_amount');
        $add->tax_type = $request->post('tax_type');
        $add->tax = $request->post('tax');
        $add->tax_amount = $request->post('tax_amount');
        $add->total_amount = $request->post('total_amount');
        $add->save();

        $did = $add->id;

        $items = $request->post('item');
        if ($items) {
            foreach ($items as $index => $item) {
                DebitItem::create([
                    'debit_id' => $did,
                    'item' => $item,
                    'hsn_sac' => $request->post('hsn_sac')[$index] ?? null,
                    'quantity' => $request->post('quantity')[$index],
                    'rate' => $request->post('rate')[$index],
                    'unit' => $request->post('unit')[$index] ?? null,
                    'amount' => $request->post('amount')[$index],
                ]);
            }
        }

        Session::flash('success', 'Debit Note has been created successfully.');
        return redirect()->route('admin.debits.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Debit $debit,$id)
    {
        $debits = Debit::join('customer_masterdatas','debits.customer_id','=','customer_masterdatas.id')
        ->join('invoices','debits.invoice_id','=','invoices.id')
        ->select('debits.*','customer_masterdatas.customer_name','customer_masterdatas.customer_address','customer_masterdatas.customer_gst','invoices.invoice_no')
        ->orderBy('debits.id', 'desc')
        ->find($id);

        $debits_items = DebitItem::where('debit_id', $id)->get();

        return view('debits.show', compact('debits', 'debits_items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debit $debit, $id)
    {
        $debits = Debit::join('customer_masterdatas','debits.customer_id','=','customer_masterdatas.id')
        ->join('invoices','debits.invoice_id','=','invoices.id')
        ->select('debits.*','customer_masterdatas.customer_name','customer_masterdatas.customer_address','customer_masterdatas.customer_gst','invoices.invoice_no')
        ->orderBy('debits.id', 'desc')
        ->find($id);

        $debits_items = DebitItem::where('debit_id', $id)->get();

        return view('debits.edit', compact('debits', 'debits_items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Debit $debit ,$id)
    {
        $update = Debit::find($id);
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
                    $creditItem = DebitItem::find($creditItemId);
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
                    DebitItem::create([
                        'debit_id' => $update->id,
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
        Session::flash('success', 'Debit Note has been updated successfully.');
        return redirect()->route('admin.debits.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debit $debit, $id)
    {
        $credit = Debit::find($id);
        $credit_items = DebitItem::where('debit_id', $id)->get();
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
