<?php

namespace App\Exports;

use App\Models\order_product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ExcelExports implements FromCollection, WithHeadings, WithMapping
{
    // protected $filters;

    public function __construct($status, $loai, $search = null, $dateFilter){
        $this->status = $status;
        $this->loai = $loai;
        $this->search = $search;
        $this->dateFilter = $dateFilter;
    }

    public function collection(){
        $query = order_product::query();
        if (!is_null($this->search)) {
            $query->where(function ($query) {
                $query->where('nameCustomer', 'LIKE', "%$this->search%")
                    ->orWhere('order_code', 'LIKE', "%$this->search%");
            });
        }
        if ($this->status != 'all') {
            $query->where('status', $this->status);
        }
        if ($this->loai != 'all') {
            $query->where('loai', $this->loai);
        }
        if (!empty($this->dateFilter)) {
            $dateParts = explode('-', $this->dateFilter);
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
            'Tên khách hàng', 
            'Số điện thoại', 
            'Địa chỉ', 
            'Tỉnh / TP', 
            'Quận / Huyện', 
            'Phường / Xã', 
            'Ghi chú', 
            'Loại', 
            'Tổng', 
            'Trạng thái giao hàng', 
            'user_id', 
            'Tên nhân viên giao hàng', 
            'Mã đơn hàng',
            'Ngày tạo', 
            'Thông tin sản phẩm', 
            'Giá trị giảm giá', 
            'Mã giảm giá', 
            'Kiểu thanh toán',
        ];
    }

    public function map($row): array{
        // Ánh xạ giá trị tương ứng
        $loai = '';
        switch ($row->loai) {
            case 1: $loai = 'Gas công nghiệp'; break;
            case 2: $loai = 'Gas dân dụng'; break;
        }

        $status = '';
        switch ($row->status) {
            case 1: $status = 'Đang xử lý'; break;
            case 2: $status = 'Đang giao'; break;
            case 3: $status = 'Đã giao'; break;
            case 4: $status = 'Đã hủy'; break;
        }

        $payment_status = '';
        switch ($row->payment_status) {
            case 1: $payment_status = 'Khi nhận hàng'; break;
            case 2: $payment_status = 'Online VNPAY'; break;
        }
        return [
            $row->id,
            $row->nameCustomer,
            $row->phoneCustomer,
            $row->diachi,
            $row->country,
            $row->state,
            $row->district,
            $row->ghichu,
            $loai,
            $row->tong,
            $status,
            $row->user_id,
            $row->admin_name,
            $row->order_code,
            $row->created_at,
            $row->infor_gas,
            $row->reduced_value,
            $row->coupon,
            $payment_status,
        ];
    }
}
