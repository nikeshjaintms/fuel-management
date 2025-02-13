<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $table = 'policies';
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle_id','policy_no','expiry_date'];
    use HasFactory;
}
