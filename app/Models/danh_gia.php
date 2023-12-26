<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class danh_gia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'danh_gia';
    protected $fillable = [
        'Comment', 'created_at','staff_id', 'order_id', 'rating', 'user_id'
    ];
}