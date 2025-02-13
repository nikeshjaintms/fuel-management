<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitness extends Model
{
    protected $table ="fitnesses";
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_id','expiry_date'];
    use HasFactory;
}
