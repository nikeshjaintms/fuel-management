<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RTO extends Model
{
    protected $table = 'r_t_o_s';
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_id','policy_no','policy_expiry_date','fitness_expiry_date','puc_expiry_date'];

    use HasFactory;
}
