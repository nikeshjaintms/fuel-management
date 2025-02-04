<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RTOTaxPayment extends Model
{
    protected $table = 'rto_tax_payment';
    protected $primaryKey = 'id';
    protected $fillable = ['rto_id','vehicle_id','month','year','payment_date','status'];

    use HasFactory;
}
