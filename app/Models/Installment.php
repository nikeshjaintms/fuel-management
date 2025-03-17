<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = "installments";
    protected $primaryKey = "id";

    protected $fillable = ['vehicle_id','amount','installment_date','status'];

    use HasFactory;
}
