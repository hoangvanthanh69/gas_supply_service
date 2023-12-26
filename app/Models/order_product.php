<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class order_product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'order_product';
    protected $fillable = [
        'nameCustomer', 'phoneCustomer', 'diachi', 'country', 'state', 'district', 'ghichu',
        'loai','tong', 'status', 'user_id', 'admin_id','order_code', 'infor_gas', 'reduced_value', 'coupon', 'payment_status'
    ];
    
}