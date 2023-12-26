<?php

namespace App\Exports;

use App\Models\add_staff;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExportsStaff implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        return add_staff::all();
    }
}
