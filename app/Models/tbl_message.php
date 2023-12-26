<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class tbl_message extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_message';
    protected $fillable = [
        'message_content', 'user_id', 'message_name', 'message_parent_message'
    ];
}