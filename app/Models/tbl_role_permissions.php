<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class tbl_role_permissions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_role_permissions';
    protected $fillable = [
        'id_admin', 'id_permissions	',
    ];
}