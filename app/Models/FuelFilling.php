<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelFilling extends Model
{
    protected $table = 'fuel_fillings';

    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_id','driver_id','customer_id','filling_date','quantity','kilometers','average_fuel_consumption'];

    use HasFactory;
    public function vehicle(){
        return $this->belongsTo(Vehicles::class,'vehicle_id','id');
    }
    public function driver(){
        return $this->belongsTo(Driver::class,'driver_id','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

}
