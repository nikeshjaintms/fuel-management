<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitItem extends Model
{
    protected $table = 'debit_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'debit_id', 'item', 'hsn_sac','quantity', 'rate','unit','amount'
    ];
    use HasFactory;
}
