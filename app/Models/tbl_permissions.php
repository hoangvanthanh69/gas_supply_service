<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class tbl_permissions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_permissions';
    protected $primaryKey = 'permission_id';
    protected $fillable = [
        'permission_name', 'id_rights_group'
    ];

}