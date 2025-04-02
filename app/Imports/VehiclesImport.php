<?php

namespace App\Imports;

use App\Models\Vehicles;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;




class VehiclesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // dd($row);
        $vehicles = Vehicles::where('vehicle_no', $row['vehicle_no'])->first();
        if($vehicles){
            return null;
        }
        if(!$row)
        {
            return null;
        }


        return new Vehicles([
            'vehicle_no' => $row['vehicle_no'],
            'type_of_vehicle' => $row['type_of_vehicle'],
            'vehicle_engine_no' => $row['vehicle_engine_no'],
            'vehicle_chassis_no' => $row['vehicle_chassis_no'],
            'average' => $row['average'],
            'road_tax_amount' => $row['road_tax_amount'],
        ]);
    }

}
