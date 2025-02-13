<?php

namespace App\Imports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class DriverImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $drivers = Driver::where('driver_name', $row['driver_name'])->first();

        if($drivers){
            return null;
        }
        return new Driver([
            'driver_name' => $row['driver_name'],
        ]);
    }

}
