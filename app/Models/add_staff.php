<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class add_staff extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'add_staff';
    protected $fillable = [
        'last_name', 'birth', 'chuc_vu', 'date_input', 'phone', 'luong', 'taikhoan', 'dia_chi', 'status_add', 'image_staff', 'CCCD', '	gioi_tinh'
    ];
}