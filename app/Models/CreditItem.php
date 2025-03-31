<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditItem extends Model
{
    protected $table = 'credit_items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'credit_id', 'item', 'hsn_sac','quantity', 'rate','unit','amount'
    ];
    use HasFactory;
}
