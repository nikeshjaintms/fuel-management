<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenace extends Model
{
    protected $table ='maintenaces';
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_id', 'vendor_id', 'invoice_no', 'invoice_date','maintenance_date','supervisor_name','total_bill_amount','status'];
    use HasFactory;
}
