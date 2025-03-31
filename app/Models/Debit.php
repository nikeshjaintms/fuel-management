<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    protected $table = 'debits';
    protected $primaryKey = 'id';

    protected $fillable = ['customer_id', 'invoice_id', 'debit_number','debit_date','subtotal_amount','tax_type','tax','tax_amount','total_amount'];
    use HasFactory;
}
