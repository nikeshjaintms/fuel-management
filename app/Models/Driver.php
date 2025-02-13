<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $table = 'drivers';
    protected $primaryKey = 'id';
    protected $fillable = ['driver_name'];
    // public function fuel_records(){
    //     return $this->hasMany(FuelFilling::class,'driver_id','id');
    // }

}

