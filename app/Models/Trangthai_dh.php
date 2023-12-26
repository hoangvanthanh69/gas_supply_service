<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'Trangthai_dh';
    protected $filltable = [
        "TTDH_Ma",
        "Ten",
        "MoTa"
    ];

    public static function getAll() {
        return Trangthai_dh::all();
    }
}


