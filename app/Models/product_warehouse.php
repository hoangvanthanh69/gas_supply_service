<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_warehouse extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'product_warehouse';
    protected $fillable = [
        'quantity', 'product_id', 'staff_id', 'batch_code', 'price', 'total', 'supplier_id'
    ];
}
