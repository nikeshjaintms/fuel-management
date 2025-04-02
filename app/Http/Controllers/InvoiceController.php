<?php

namespace App\Http\Controllers;

use App\Models\ContractVehicle;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Invoice_vehicle;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


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

        // Determine the current fiscal year
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        $previousYear = $currentYear - 1;

        // Determine if the fiscal year should be previous year - current year or current year - next year
        if (date('m') < 4) {
            // Before April 1st, use the previous fiscal year
            $fiscalYear = ($previousYear % 100) . '-' . ($currentYear % 100);
        } else {
            // From April 1st onwards, use the current fiscal year
            $fiscalYear = ($currentYear % 100) . '-' . ($nextYear % 100);
        }

        // Get the latest invoice for the current fiscal year
        $latestInvoice = Invoice::where('invoice_no', 'LIKE', "%/$fiscalYear/%")->latest()->first();

        // Extract and increment the last number, reset if new fiscal year
        if ($latestInvoice) {
            $lastNumber = intval(explode('/', $latestInvoice->invoice_no)[2]);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1; // Reset if no invoice exists for this fiscal year
        }

        // Format the invoice number
        $invoiceNumber = 'DIVYA/' . $fiscalYear . '/' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // dd($invoiceNumber);

        return view('invoice.create', compact('customers', 'invoiceNumber'));
    }

    public function checkContract(Request $request)
    {
        $exists = Invoice::where('contract_id', $request->contract_id)->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $add = new Invoice();
        $add->customer_id = $request->post('customer_id');
        $add->contract_id = $request->post('contract_id');
        $add->invoice_no = $request->post('invoice_no');
        $add->invoice_date = $request->post('invoice_date');
        $add->start_date = $request->post('start_date');
        $add->end_date = $request->post('end_date');
        $add->from_point = $request->post('from_point');
        $add->to_point = $request->post('to_point');
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
        return redirect()->route('invoice.success', ['id' => $invoice_id]);

    }

    public function getInvoices($customer_id)
    {
        $invoices = Invoice::where('customer_id', $customer_id)->get(['id', 'invoice_no']);
        return response()->json($invoices);
    }

    public function downloadInvoiceDetails($id)
    {
        $invoices = Invoice::join('contracts', 'invoices.contract_id', '=', 'contracts.id')
            ->join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
            ->select('invoices.*', 'contracts.contract_no', 'contracts.contract_date', 'customer_masterdatas.customer_name', 'customer_masterdatas.customer_address', 'customer_masterdatas.customer_gst')
            ->where('invoices.id', $id)
            ->first();

        if (!$invoices) {
            return back()->withErrors(['message' => 'Invoice not found']);
        }

        $invoice_vehicles = Invoice_vehicle::leftjoin('vehicles', 'invoice_vehicle.vehicle_id', '=', 'vehicles.id')
            ->select('invoice_vehicle.*', 'vehicles.vehicle_no')
            ->where('invoice_vehicle.invoice_id', $id)
            ->get();
        $contract_vehicles = ContractVehicle::where('contract_id', $invoices->contract_id)->get();

        $pdf = Pdf::loadView('invoice.pdf', [
            'invoices' => $invoices,
            'invoice_vehicles' => $invoice_vehicles,
            'contract_vehicles' => $contract_vehicles,
            'isCancelled' => $invoices->status === 'cancelled'
        ]);

        $invoiceNo = str_replace('/', '-', (string) $invoices->invoice_no);
        return $pdf->stream('invoice-' . $invoiceNo . '.pdf');
    }

    /**
     * Display the specified resource.
     */


    public function show(Invoice $invoice, $id)
    {
        $invoices = Invoice::join('contracts', 'invoices.contract_id', '=', 'contracts.id')
            ->join('customer_masterdatas', 'contracts.customer_id', '=', 'customer_masterdatas.id')
            ->select('invoices.*', 'contracts.contract_no', 'customer_masterdatas.customer_name')
            ->where('invoices.id', $id)
            ->first(); // FIXED: Use where() and first() instead of find()


        if (!$invoices) {
            return back()->withErrors(['message' => 'Invoice not found']);
        }

        $invoice_vehicles = Invoice_vehicle::leftjoin('vehicles', 'invoice_vehicle.vehicle_id', '=', 'vehicles.id')
            ->select('invoice_vehicle.*', 'vehicles.vehicle_no')
            ->where('invoice_vehicle.invoice_id', $id)

            ->get();

        $contract_vehicles = ContractVehicle::where('contract_id', $invoices->contract_id)->get();

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


    public function bulkPayInvoices(Request $request)
    {
        if (!$request->has('invoice_ids') || empty($request->invoice_ids)) {
            return response()->json(['success' => false, 'message' => 'No invoices selected.']);
        }

        // Count already paid invoices
        $invalidInvoices = Invoice::whereIn('id', $request->invoice_ids)
            ->whereIn('status', ['paid', 'cancelled'])
            ->count();

        if ($invalidInvoices == count($request->invoice_ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Selected invoices are either already paid or cancelled.',
            ]);
        }

        // Update only pending invoices to paid
        Invoice::whereIn('id', $request->invoice_ids)
            ->where('status', 'pending')
            ->update([
                'status' => 'Paid',
            ]);

        return response()->json(['success' => true, 'message' => 'Invoices marked as paid successfully.']);
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

        return view('invoice.edit', compact('customers', 'invoices', 'invoice_vehicles', 'contract_vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice, $id)
    {
        // dd($request->all());

        $invoice = Invoice::findOrFail($id);
        $invoice->start_date = $request->post('start_date');
        $invoice->end_date = $request->post('end_date');
        $invoice->from_point = $request->post('from_point');
        $invoice->to_point = $request->post('to_point');
        $invoice->total_km = $request->post('total_km');
        $invoice->diesel_diff_rate = $request->post('diesel_diff_rate');
        $invoice->diesel_cost = $request->post('diesel_cost');
        $invoice->grand_subtotal = $request->post('grand_subtotal');
        $invoice->tax_type = $request->post('tax_type');
        $invoice->tax = $request->post('tax');
        $invoice->tax_amount = $request->post('tax_amount');
        $invoice->total_amount = $request->post('total_amount');

        $invoice->save();

        $invoice_id = $invoice->id;

        // Store vehicle IDs to track which ones were updated/added
        $updatedVehicleIds = [];

        if ($request->has('vehicle_id')) {
            foreach ($request->vehicle_id as $key => $vehicle_id) {
                $invoiceVehicle = Invoice_vehicle::updateOrCreate(
                    [
                        'invoice_id' => $invoice->id,
                        'vehicle_id' => $vehicle_id,
                    ],
                    [
                        'extra_km_drive' => $request->extra_km_drive[$key] ?? 0,
                        'km_drive' => $request->km_drive[$key] ?? 0,
                        'total_extra_km_amount' => $request->total_extra_km_amount[$key] ?? 0,
                        'overtime' => $request->overtime[$key] ?? 0,
                        'overtime_amount' => $request->overtime_amount[$key] ?? 0,
                    ]
                );

                $updatedVehicleIds[] = $invoiceVehicle->id;
            }
        }

        return redirect()->away(route('admin.invoice.getInvoiceDetails', ['id' => $invoice_id]));;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Delete associated vehicles
        Invoice_vehicle::where('invoice_id', $invoice->id)->delete();

        // Delete the invoice
        $invoice->delete();

        return response()->json(['success' => 'Invoice deleted successfully.']);
    }
}
