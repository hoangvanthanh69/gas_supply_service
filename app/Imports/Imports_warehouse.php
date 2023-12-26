<?php

namespace App\Imports;

use App\Models\product_warehouse;
use Maatwebsite\Excel\Concerns\ToModel;

class Imports_warehouse implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new product_warehouse([
            'quantity' => $row[0],
            'product_id' => $row[1],
            'staff_id' => $row[2],
            'batch_code' => $row[5],
            'price' => $row[6],
            'total' => $row[7],
            'supplier_id' => $row[8],
        ]);
    }
}
