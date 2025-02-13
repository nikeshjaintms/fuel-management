<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'phone_number', 'address','vendor_gst'];
    use HasFactory;
}
