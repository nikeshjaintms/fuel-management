<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $customer = Customer::where('customer_name', $row['customer_name'])->first();

        if($customer){
            return null;
        }

        return new Customer([
            'customer_type' => $row['customer_type'],
            'customer_name' => $row['customer_name'],
            'customer_address' => $row['customer_address'],
            'customer_mobile_no' => $row['customer_mobile_no'],
            'customer_email' => $row['customer_email'],
        ]);
    }
}
