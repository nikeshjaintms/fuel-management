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
        $policydate = Date::excelToDateTimeObject($row['vehicle_policy_expiry_date']);
        $fitnessdate = Date::excelToDateTimeObject($row['vehicle_fitness_expiry_date']);
        $pucdate = Date::excelToDateTimeObject($row['vehicle_puc_expiry_date']);

        return new Vehicles([
            'vehicle_no' => $row['vehicle_no'],
            'vehicle_engine_no' => $row['vehicle_engine_no'],
            'vehicle_chassis_no' => $row['vehicle_chassis_no'],
            'vehicle_policy_no' => $row['vehicle_policy_no'],
            'average' => $row['average'],
            'vehicle_policy_expiry_date' => $policydate,
            'vehicle_fitness_expiry_date' => $fitnessdate,
            'vehicle_puc_expiry_date' => $pucdate,

            //
        ]);
    }

}
