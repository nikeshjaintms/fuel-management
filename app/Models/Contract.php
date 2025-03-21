<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
    protected $primaryKey = 'id';
    protected $fillable = ['customer_id','start_date','end_date','min_km','rate','extra_km_rate','rate_per_hour'];
    use HasFactory;
}
