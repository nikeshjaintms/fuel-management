<?php

namespace App\Exports;

use App\Models\Vehicles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehiclesExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vehicles::all();
    }
    public function headings(): array
    {
        return ['ID', 'Registertion No', 'Engine No','Chassis No', 'Policy No', 'Policy Expiry Date', 'Fitness Expiry Date','PUC Expiry Date','Average(Claim by Company)'];
    }
}
