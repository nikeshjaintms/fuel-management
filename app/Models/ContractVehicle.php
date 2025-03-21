<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractVehicle extends Model
{
    protected $table = 'contract_vehicles';
    protected $primaryKey = 'id';
    protected $fillable = ['contract_id','vehicle_id','type','min_km','rate','extra_km_rate','rate_per_hour'];
    use HasFactory;
}
