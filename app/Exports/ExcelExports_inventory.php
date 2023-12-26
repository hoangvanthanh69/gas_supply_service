<?php

namespace App\Exports;

use App\Models\product;
use App\Models\product_warehouse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelExports_inventory implements FromCollection, WithHeadings, WithMapping
{
    protected $loai;
    protected $search;
    public function __construct($loai, $search = null){
        $this->loai = $loai;
        $this->search = $search;
    }

    public function collection(){
        return product::query()
            ->when(!is_null($this->search), function ($query) {
                $query->where(function ($innerQuery) {
                    $innerQuery->orWhere('id', 'LIKE', "%$this->search%")
                        ->orWhere('name_product', 'LIKE', "%$this->search%");
                });
            })
            ->when($this->loai !== 'all', function ($query) {
                $query->where('loai', $this->loai);
            })->get();
    }

    public function headings(): array{
        return [
            'ID',
            'Tên sản phẩm',
            'Loại',
            'SL Trong Kho',
            'Giá bán',
            'Tổng SL Nhập',
            'Tổng Giá Trong Kho',
            'Tổng Giá Nhập',
            'SL Đã Bán',
        ];
    }

    public function map($row): array{
        $loai = '';
        switch ($row->loai) {
            case 1:
                $loai = 'Gas công nghiệp';
                break;
            case 2:
                $loai = 'Gas dân dụng';
                break;
        }

        $totalQuantity = product_warehouse::where('product_id', $row->id)->sum('quantity');
        $totalPrice = product_warehouse::where('product_id', $row->id)->sum('total');
        $quantity_sold = ($totalQuantity ?? 0) - $row->quantity;
        return [
            $row->id,
            $row->name_product,
            $loai,
            $row->quantity,
            $row->price,
            $totalQuantity,
            $totalQuantity * $row->price,
            $totalPrice,
            $quantity_sold,
        ];
    }
}