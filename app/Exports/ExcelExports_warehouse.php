<?php

namespace App\Exports;

use App\Models\product_warehouse;
use App\Models\tbl_admin;
use App\Models\product;
use App\Models\tbl_supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelExports_warehouse implements FromCollection, WithHeadings, WithMapping
{
    protected $date_Filter_warehouse;
    protected $date_Filter_warehouse_start;
    protected $date_Filter_warehouse_end;
    protected $search;
    protected $productIds;
    protected $staffIds;

    public function __construct($date_Filter_warehouse, $search = null, $productIds, $staffIds,
        $date_Filter_warehouse_start, $date_Filter_warehouse_end){
        $this->date_Filter_warehouse = $date_Filter_warehouse;
        $this->date_Filter_warehouse_start = $date_Filter_warehouse_start;
        $this->date_Filter_warehouse_end = $date_Filter_warehouse_end;
        $this->search = $search;
        $this->productIds = $productIds;
        $this->staffIds = $staffIds;
    }

    public function collection(){
        $query = product_warehouse::query();
        if (!is_null($this->search)) {
            $query->where(function ($query) {
                $query->orWhere('batch_code', 'LIKE', "%$this->search%")
                    ->orWhere('product_id', 'LIKE', "%$this->search%")
                    ->orwhereIn('product_id', $this->productIds)
                    ->orWhereIn('staff_id', $this->staffIds);
            });
        }
        if (!empty($this->date_Filter_warehouse_start) && !empty($this->date_Filter_warehouse_end)) {
            $start = date('Y-m-d', strtotime($this->date_Filter_warehouse_start));
            $end = date('Y-m-d', strtotime($this->date_Filter_warehouse_end .'+1 day'));
            $query->whereBetween('created_at', [$start, $end]);
        }        
        if (!empty($this->date_Filter_warehouse)) {
            $dateParts = explode('-', $this->date_Filter_warehouse);
            $day = null;
            $month = null;
            $year = null;
            if (count($dateParts) >= 1) {
                $year = $dateParts[count($dateParts) - 1];
            }
            if (count($dateParts) >= 2) {
                $month = $dateParts[count($dateParts) - 2];
            }
            if (count($dateParts) >= 3) {
                $day = $dateParts[count($dateParts) - 3];
            }
            if ($day) {
                $query->whereDate('created_at', '=', "$year-$month-$day");
            } elseif ($month) {
                $query->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month);
            } else {
                $query->whereYear('created_at', '=', $year);
            }
        }
        return $query->get();
    }
    public function headings(): array{
        return [
            'ID',
            'Mã nhập',
            'Tên sản phẩm',
            'Nhà cung cấp',
            'Số lượng',
            'Giá nhập',
            'Tổng',
            'Nhân viên thêm',
            'Ngày nhập',
        ];
    }
    public function map($row): array{
        $productName = product::find($row->product_id)->name_product;
        $adminName = tbl_admin::find($row->staff_id)->admin_name;
        $name_supplier = tbl_supplier::find($row->supplier_id)->name_supplier;
        return [
            $row->id,
            $row->batch_code,
            $productName,
            $name_supplier,
            $row->quantity,
            $row->price,
            $row->total,
            $adminName,
            $row->created_at,
        ];
    }
}
