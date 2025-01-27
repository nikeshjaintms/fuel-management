<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelFilling extends Model
{
    protected $table = 'fuel_fillings';

    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_id','driver_id','filling_date','quantity','kilometers','average_fuel_consumption'];

    use HasFactory;
}
