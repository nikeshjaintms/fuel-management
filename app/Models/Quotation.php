<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = "quotations";
    protected $primaryKey = 'id';

    protected $fillable = ['customer_id','quotation_date','gst_charge','price_variation','present_fuel_rate'];
    use HasFactory;
}
