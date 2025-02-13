<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PUC extends Model
{
    protected $table = 'p_u_c_s';
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_id','expiry_date'];
    use HasFactory;
}
