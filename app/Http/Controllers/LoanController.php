<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Vehicles;
use App\Models\Installment;
use Illuminate\Http\Request;
use Session;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::join('vehicles','loans.vehicle_id','=','vehicles.id')
        ->select('loans.*','vehicles.vehicle_no')
        ->get();
        return view('loan.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicles::get();
        return view('loan.create', compact('vehicles'));
    }

    public function checkVehicle(Request $request)
    {
        $exists = Loan::where('vehicle_id', $request->vehicle_id)->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'This vehicle is already associated with a loan.' : ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $loan = new Loan();
        $loan->vehicle_id = $request->post('vehicle_id');
        $loan->finance_by = $request->post('finance_by');
        $loan->loan_amount = $request->post('loan_amount');
        $loan->loan_account = $request->post('loan_account');
        $loan->emi_amount = $request->post('emi_amount');
        $loan->total_emi = $request->post('total_emi');
        $loan->emi_paid = $request->post('emi_paid');
        $loan->pending_emi = $request->post('pending_emi');
        $loan->start_date= $request->post('start_date');
        $loan->end_date= $request->post('end_date');
        $loan->rate_of_interest = $request->post('rate_of_interest');
        $loan->status = ($request->post('pending_emi') == 0) ? "Completed" : "On Going";;
        $loan->save();

        $installment = new Installment();
        $installment->vehicle_id = $request->post('vehicle_id');
        $installment->loan_id = $loan->id;
        $installment->amount = $request->post('emi_amount');
        $installment->installment_date = $request->post('installment_date');
        $installment->save();

        Session::flash('success', 'Loan created successfully.');
        return redirect()->route('admin.loan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan, $id)
    {
        $data = Loan::join('vehicles','loans.vehicle_id','=','vehicles.id')
        ->select('loans.*','vehicles.vehicle_no')->find($id);
        return view('loan.show', compact('data'));
    }

    public function updateEmiPaid(Request $request)
    {
        if (!$request->has('ids') || empty($request->ids)) {
            return response()->json(['message' => 'No loans selected'], 400);
        }

        $ids = $request->ids;
        $loans = Loan::whereIn('id', $ids)->get();

        $updatedLoans = [];
        $skippedLoans = [];

        foreach ($loans as $loan) {
            // Check if loan is already fully paid
            if ($loan->emi_paid == $loan->total_emi && $loan->pending_emi == 0) {
                $skippedLoans[] = $loan->id;
                continue; // Skip updating this loan
            }

            // Only update if emi_paid is less than total_emi
            if ($loan->emi_paid < $loan->total_emi) {
                $loan->increment('emi_paid', 1);

                // Decrease pending_emi if it's greater than 0
                if ($loan->pending_emi > 0) {
                    $loan->decrement('pending_emi', 1);
                }
                if ($loan->emi_paid == $loan->total_emi && $loan->pending_emi == 0) {
                    $loan->status = 'Completed';
                    $loan->save();
                }

                $updatedLoans[] = $loan->id;
            }
        }

        if (empty($updatedLoans) && !empty($skippedLoans)) {
            return response()->json(['message' => 'All selected loans are already paid.'], 400);
        }

        return response()->json([
            'message' => 'EMI updated successfully.',
            'updated_loans' => $updatedLoans,
            'skipped_loans' => $skippedLoans
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan,$id)
    {
        $vehicles = Vehicles::get();
        $data = Loan::find($id);
        $installment = Installment::where('loan_id',$id)->first();
        return view('loan.edit', compact('vehicles', 'data', 'installment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan,$id)
    {
        $loan = Loan::find($id);
        $loan->vehicle_id = $request->post('vehicle_id');
        $loan->finance_by = $request->post('finance_by');
        $loan->loan_amount = $request->post('loan_amount');
        $loan->loan_account = $request->post('loan_account');
        $loan->emi_amount = $request->post('emi_amount');
        $loan->total_emi = $request->post('total_emi');
        $loan->emi_paid = $request->post('emi_paid');
        $loan->pending_emi = $request->post('pending_emi');
        $loan->start_date= $request->post('start_date');
        $loan->end_date= $request->post('end_date');
        $loan->rate_of_interest = $request->post('rate_of_interest');
        $loan->status = ($request->post('pending_emi') == 0) ? "Completed" : "On Going";
        $loan->save();

        $installment = Installment::where('loan_id', $id)->first();
        $installment->amount = $request->post('emi_amount');
        $installment->installment_date = $request->post('installment_date');
        $installment->save();

        Session::flash('success', 'Loan updated successfully.');
        return redirect()->route('admin.loan.index');


        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan, $id)
{
    $loan = Loan::find($id);

    if (!$loan) {
        return response()->json(['error' => 'Loan not found'], 404);
    }

    $installment = Installment::where('loan_id', $id)->first();

    if ($installment) {
        $installment->delete();
    }

    $loan->delete();

    return response()->json(['message' => 'Loan Deleted Successfully']);
}

}
