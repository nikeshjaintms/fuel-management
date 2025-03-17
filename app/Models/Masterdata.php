<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterdata extends Model
{
    protected $table ='masterdatas';
    protected $primaryKey = 'id';

    protected $fillable = [ 'id','owner_name','vehicle_id','type','asset_make_model','segment','model','body','yom','finance_by','loan_amount','loan_account','emi_amount','total_emi','emi_paid','pending_emi','start_date','end_date','customer_id','rate_of_interest','status'];
    use HasFactory;
}
