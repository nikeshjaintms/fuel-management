<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $primaryKey = 'id';

    protected $fillable =['contract_id', 'invoice_no','invoice_date','total_km','diesel_diff_rate','diesel_cost','grand_subtotal','tax_type','tax','tax_amount','total_amount'];
    use HasFactory;
}
