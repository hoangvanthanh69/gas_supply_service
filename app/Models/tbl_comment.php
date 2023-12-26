<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class tbl_comment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_comment';
    protected $fillable = [
        'comment', 'comment_name','comment_date', 'staff_id', 'user_id', 'status_comment', 'comment_parent_comment'
    ];
}