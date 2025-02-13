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
        return FuelFilling::join('vehicles','fuel_fillings.vehicle_id','=','vehicles.id')
        ->join('drivers','fuel_fillings.driver_id','=','drivers.id')
        ->join('customer_masterdatas','fuel_fillings.customer_id','=','customer_masterdatas.id')
        ->select('fuel_fillings.*','vehicles.vehicle_no','drivers.driver_name','customer_masterdatas.customer_name')
        ->get()
        ->map(function($fuelFilling){
            return [
                'id' => $fuelFilling->id,
                'vehicle_no' => $fuelFilling->vehicle_no,
                'driver' => $fuelFilling->driver_name,
                'customer' => $fuelFilling->customer_name,
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
