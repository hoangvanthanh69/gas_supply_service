<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_vnpay extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_vnpay';
    protected $fillable = [
        'vnp_Amount', 'vnp_BankCode', 'vnp_BankTranNo', 'vnp_CardType', 'vnp_OrderInfo', 'vnp_PayDate', 
        'vnp_TmnCode', 'vnp_TransactionNo', 'user_id', 'order_id'
    ];
}