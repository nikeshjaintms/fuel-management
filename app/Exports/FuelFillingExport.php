<?php

namespace App\Exports;

use App\Models\FuelFilling;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FuelFillingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // dd(FuelFilling::get());

        return FuelFilling::with('vehicle','driver','customer')->get()

        ->map(function($fuelFilling){
            return [
                'id' => $fuelFilling->id,
                'vehicle_no' => $fuelFilling->vehicle->vehicle_no,
                'driver' => $fuelFilling->driver->driver_name,
                'company' => $fuelFilling->customer->customer_name,
                'filling_date' => $fuelFilling->filling_date,
                'quantity' => $fuelFilling->quantity,
                'km' => $fuelFilling->kilometers,
                'average' => $fuelFilling->vehicle->average,
                'average_fuel_consumption' => $fuelFilling->average_fuel_consumption,
            ];
        });
    }
    public function headings(): array
    {
        return ['ID', 'Vehicle No', 'Driver','Company', 'Filling Date', 'Quantity', 'KM','Average','Average Fuel Consumption'];
    }
}
