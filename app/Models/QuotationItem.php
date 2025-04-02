<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $table = "quotation_items";
    protected $primaryKey = "id";

    protected $fillable = ['quotation_id','type_of_vehicle','km','rate','extra_km_rate','over_time_rate','average'];
    use HasFactory;
}
