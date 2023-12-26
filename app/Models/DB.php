<?php

namespace App\Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class DB {
    public static function procCall ($callback) {
        return Capsule::select('call ' . $callback);
    }
    public static function funcCall ($callback) {
        return (Capsule::select('select '. $callback . '() as result'))[0]->result;
    }
    public static function xoakh ($id) {
        return Capsule::select("call xoakh ('".$id."')");
    }
}
