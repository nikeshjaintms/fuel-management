<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_no','vehicle_engine_no','vehicle_chassis_no','average'];

    use HasFactory;

    // public function fuel_records(){
    //     return $this->hasMany(FuelFilling::class,'vehicle_id','id');
    // }
}
