<?php

namespace App\Http\Controllers;

use App\Models\Maintenace;
use App\Models\Vehicles;
use App\Models\Vendor;
use App\Models\MaintenanceItem;
use App\Models\Product;
use Illuminate\Http\Request;

class MaintenaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = Maintenace::join('vehicles','maintenaces.vehicle_id','=','vehicles.id')
            ->join('vendors','maintenaces.vendor_id','=','vendors.id')
            ->select('maintenaces.*','vehicles.vehicle_no','vendors.name as vendor_name')
            ->get();

        return view('maintenances.index', compact('maintenances'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::get();
        $vehicles = Vehicles::get();

        return view('maintenances.create', compact('vendors', 'vehicles'));
    }

    public function checkMaintenance(Request $request)
    {
        $exists = Maintenace::where('invoice_no', $request->invoice_no)
            ->where('invoice_date', $request->invoice_date)
            ->where('vehicle_id', $request->vehicle_id)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Save maintenance details
        $maintenance = new Maintenace();
        $maintenance->vehicle_id = $request->post('vehicle_id');
        $maintenance->vendor_id = $request->post('vendor_id');
        $maintenance->invoice_no = $request->post('invoice_no');
        $maintenance->maintenance_date = $request->post('maintenance_date');
        $maintenance->invoice_date = $request->post('invoice_date');
        $maintenance->supervisor_name = $request->post('supervisor_name');
        $maintenance->km_driven = $request->post('km_driven');
        $maintenance->next_service_date = $request->post('next_service_date');
        $maintenance->total_bill_amount = $request->post('total_bill_amount');
        $maintenance->status = $request->post('status');
        $maintenance->save();

        // Loop through submitted products and store them
        if ($request->has('product_name')) {
            foreach ($request->product_name as $index => $productName) {
                $hsn = $request->hsn[$index] ?? null;

                // Check if product exists by name and hsn
                $product = Product::where('name', $productName)
                ->where('hsn_code', $hsn)
                ->first();

                if (!$product) {
                    // Create a new product if not found
                    $product = Product::create([
                        'name' => $productName,
                        'hsn_code' => $hsn,
                        'description' => $request->description[$index] ?? null,
                    ]);
                }

                // Store maintenance item referencing the product

                $item = new MaintenanceItem();
                $item->maintenaces_id = $maintenance->id;
                $item->product_id = $product->id; // Store product reference
                $item->unit = $request->unit[$index] ?? null;
                $item->quantity = $request->quantity[$index] ?? 0;
                $item->rate = $request->cost[$index] ?? 0;
                $item->discount = $request->discount[$index] ?? 0;
                $item->amount_without_tax = $request->amount_without_tax[$index] ?? 0;
                $item->tax = $request->tax[$index] ?? 0;
                $item->tax_amount = $request->tax_amount[$index] ?? 0;
                $item->amount = $request->amount[$index] ?? 0;
                $item->save();
            }
        }

        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance information added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maintenance = Maintenace::join('vendors','maintenaces.vendor_id','=','vendors.id')
        ->join('vehicles','maintenaces.vehicle_id','=','vehicles.id')
        ->select('maintenaces.*','vendors.name as vendor_name','vehicles.vehicle_no')
        ->find($id);
        $maintenanceItems = MaintenanceItem::join('products','maintenance_items.product_id','=','products.id')->where('maintenaces_id', $id)->get();

        return view('maintenances.show', compact('maintenance','maintenanceItems'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vendors = Vendor::get();
        $vehicles = Vehicles::get();
        $maintenance = Maintenace::find($id);

        if (!$maintenance) {
            return redirect()->route('admin.maintenance.index')->with('error', 'Maintenance record not found!');
        }

        // Fetch related maintenance items along with product details
        $maintenanceItems = MaintenanceItem::join('products','maintenance_items.product_id','=','products.id')->where('maintenaces_id', $id)->get();

        return view('maintenances.edit', compact('vendors','vehicles','maintenance', 'maintenanceItems'));
        // return view('maintenances.edit',compact([]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the existing maintenance record
        $maintenance = Maintenace::findOrFail($id);

        // Update maintenance details
        $maintenance->vehicle_id = $request->post('vehicle_id');
        $maintenance->vendor_id = $request->post('vendor_id');
        $maintenance->invoice_no = $request->post('invoice_no');
        $maintenance->maintenance_date = $request->post('maintenance_date');
        $maintenance->invoice_date = $request->post('invoice_date');
        $maintenance->supervisor_name = $request->post('supervisor_name');
        $maintenance->km_driven = $request->post('km_driven');
        $maintenance->next_service_date = $request->post('next_service_date');
        $maintenance->total_bill_amount = $request->post('total_bill_amount');
        $maintenance->status = $request->post('status');
        $maintenance->save();

        // Process maintenance items
        if ($request->has('product_name')) {
            $existingItemIds = [];

            foreach ($request->product_name as $index => $productName) {
                $hsn = $request->hsn[$index];

                // Check if the product exists by name and HSN code
                $product = Product::where('name', $productName)
                    ->where('hsn_code', $hsn)
                    ->first();

                if ($product) {
                    $product->name = $request->name[$index] ?? $product->name;
                    $product->description = $request->description[$index] ?? $product->description;
                    $product->save();
                } else {
                    // Create new product
                    $product = new Product();
                    $product->name = $productName;
                    $product->hsn_code = $hsn;
                    $product->description = $request->description[$index] ?? null;
                    $product->save();
                }

                // Update or create maintenance item
                $maintenanceItem = MaintenanceItem::updateOrCreate(
                    [
                        'maintenaces_id' => $maintenance->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'quantity' => $request->quantity[$index],
                        'unit' => $request->unit[$index],
                        'rate' => $request->cost[$index],
                        'discount' => $request->discount[$index],
                        'amount_without_tax' => $request->amount_without_tax[$index],
                        'tax' => $request->tax[$index],
                        'tax_amount' => $request->tax_amount[$index],
                        'amount' => $request->amount[$index],
                    ]
                );

                // Collect updated item IDs
                $existingItemIds[] = $maintenanceItem->id;
            }

            // Delete items that were removed from the form
            MaintenanceItem::where('maintenaces_id', $maintenance->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();
        }

        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maintenance = Maintenace::find($id);

        if ($maintenance) {
            // Delete all related maintenance items
            MaintenanceItem::where('maintenaces_id', $id)->delete();

            // Now delete the maintenance record
            $maintenance->delete();

            return response()->json(['success' => 'Maintenance record deleted successfully.']);
        }

        return response()->json(['error' => 'Maintenance record not found.'], 404);

    }
}
