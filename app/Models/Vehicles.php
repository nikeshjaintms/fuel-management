<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_no','vehicle_engine_no','vehicle_chassis_no','vehicle_policy_no','vehicle_policy_expiry_date','vehicle_fitness_expiry_date','vehicle_puc_expiry_date'];

    use HasFactory;
}
