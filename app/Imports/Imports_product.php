<?php

namespace App\Imports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\ToModel;

class Imports_product implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new product([
            'name_product' => $row[0],
            'loai' => $row[1],
            'original_price' => $row[2],
            'price' => $row[3],
            'image' => $row[4],
            'quantity' => $row[5],
            'unit' => $row[6],
        ]);
    }
}
