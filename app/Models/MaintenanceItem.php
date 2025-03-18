<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceItem extends Model
{
    protected $table = 'maintenance_items';
    protected $primaryKey ='id';
    protected $fillable = ['maintenaces_id','product_id','quantity','unit','rate','discount','amount_without_tax','tax','tax_amount','amount'];

    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
