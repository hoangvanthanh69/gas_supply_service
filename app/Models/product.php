<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_product';
    protected $fillable = [
        'name_product', 'loai', 'price', 'quantity', 'original_price', "image", "new_quantity", "unit"
    ];

    function product_total() {
        return product::select()->count();
    }
}


