<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class tbl_supplier extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_supplier';
    protected $fillable = [
        'name_supplier',
    ];

}