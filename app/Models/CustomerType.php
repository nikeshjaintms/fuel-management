<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    protected $table = 'customer_type';
    protected $primaryKey = 'id';
    protected $fillable = ['customer_type'];
    use HasFactory;
}
