<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class add_order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'add_order';
    protected $fillable = [
        'infor_gas','nameCustomer', 'phoneCustomer', 'diachi', 'country', 'state', 'district','ghichu',
        'loai','status', 'user_id', 'admin_id','order_code'
    ];
}