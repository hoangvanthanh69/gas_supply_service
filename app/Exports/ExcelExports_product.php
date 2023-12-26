<?php

namespace App\Exports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ExcelExports_product implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($loai, $search = null){
        $this->loai = $loai;
        $this->search = $search;
    }

    public function collection(){
        $query = product::query();
        if (!is_null($this->search)) {
            $query->where(function ($query) {
                $query->where('id', 'LIKE', "%$this->search%")
                ->orWhere('name_product', 'LIKE', "%$this->search%");
            });
        }
        if ($this->loai != 'all') {
            $query->where('loai', $this->loai);
        }
        return $query->get();
    }
    

    public function headings(): array{
        return [
            'ID',
            'Tên sản phẩm', 
            'Loại', 
            'Giá nhập', 
            'Giá bán', 
            'Ảnh', 
            'Số lượng', 
            'Ngày thêm', 
        ];
    }

    public function map($row): array{
        // Ánh xạ giá trị tương ứng
        $loai = '';
        switch ($row->loai) {
            case 1: $loai = 'Gas công nghiệp'; break;
            case 2: $loai = 'Gas dân dụng'; break;
        }
        return [
            $row->id,
            $row->name_product,
            $loai,
            $row->original_price,
            $row->price,
            $row->image,
            $row->quantity,
            $row->created_at,
        ];
    }
}
