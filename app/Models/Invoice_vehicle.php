<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_vehicle extends Model
{
    protected $table = 'invoice_vehicle';
    protected $fillable = ['invoice_id','vehicle_id','extra_km_drive','km_drive','total_extra_km_amount','overtime','overtime_amount'];
    use HasFactory;
}
