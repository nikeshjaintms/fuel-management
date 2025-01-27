<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMasterdata extends Model
{
    protected $table = 'customer_masterdatas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_name',
        'customer_address',
        'customer_type',
        'customer_mobile_no',
        'customer_email',
    ];
    use HasFactory;
}
