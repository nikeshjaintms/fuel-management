<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $table = 'credits';
    protected $primaryKey = 'id';
    protected $fillable = ['customer_id', 'invoice_id', 'credit_number','credit_date','subtotal_amount','tax_type','tax','tax_amount','total_amount'];

    use HasFactory;
}
