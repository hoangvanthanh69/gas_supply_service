<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\order_product;
use App\Models\product;
use PDF;
use Excel;
use App\Exports\ExcelExports;
class OrderController extends Controller
{
    // quản lý hóa đơn
    function quan_ly_hd(Request $request) {
        if (!Session::get('admin')) {
            return redirect()->route('login');
        }
        $admin_name = Session::get('admin')['admin_name'];
        $chuc_vu = Session::get('admin')['chuc_vu'];
        if ($chuc_vu == '2') {
            $order_product = order_product::orderByDesc('created_at')->get()->toArray();
        } else {
            $order_product = order_product::where(['admin_name' =>$admin_name])->orderByDesc('created_at')->get()->toArray();
        }
        $filters = [
            'status' => $request->input('status', 'all'),
            'loai' => $request->input('loai', 'all')
        ];
        $search = $request->input('search');
        $dateFilter = $request->input('dateFilter');
        // dd($filters);
        return view('backend.quan_ly_hd', [
            'order_product' => $order_product,
            'search' => $search,
            'filters' => $filters,
            'dateFilter' => $dateFilter,
        ]);
    }

    function chitiet_hd(Request $request, $id){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $order_product = order_product::find($id);
        if (!$order_product) {
            return redirect()->route('quan_ly_hd')->with('error', 'Không tìm thấy đơn hàng.');
        }
        $infor_gas = json_decode($order_product['infor_gas'], true);
        $products = [];
        if ($infor_gas) {
            foreach ($infor_gas as $infor) {
                $product = product::find($infor['product_id']);
                if ($product) {
                    $products[] = [
                        'product' => $product,
                        'product_name' => $infor['product_name'],
                        'product_price' => $infor['product_price'],
                        'quantity' => $infor['quantity'],
                    ];
                }
            }
        }
        return view('backend.chitiet_hd' , ['order_product' => $order_product, 'products' => $products]);
    }
    
    // xóa đơn hàng
    function delete_order($id){
        $order_product = order_product::find($id);
        $order_product->delete();
        return redirect()->route('quan-ly-hd')->with('success','Xóa đơn hàng thành công');;
    }

    //lọc đơn hàng theo loại và trạng thái
    function filters_status_type(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $filters = [
            'status' => $request->input('status', 'all'),
            'loai' => $request->input('loai', 'all')
        ];
        $search = $request->input('search');
        $dateFilter = $request->input('dateFilter');
        $order_product = order_product::get();
        return view('backend.quan_ly_hd', ['order_product' => $order_product, 'search' => $search, 'filters' => $filters,
            'dateFilter' => $dateFilter
        ]);
    }

     //lọc đơn hàng theo tên a-z, z-a
    function sort_order(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $query = order_product::query();
        $sortOrder = $request->input('sort_order', 'asc');
        if ($sortOrder == 'asc') {
            $query->orderBy('nameCustomer', 'asc'); 
        } else {
            $query->orderBy('nameCustomer', 'desc');
        }
        $filters = [
            'status' => $request->input('status', 'all'),
            'loai' => $request->input('loai', 'all'),
            'sort_order' => $sortOrder,
        ];
        $search = $request->input('search');
        $dateFilter = $request->input('dateFilter');
        $order_product = $query->get()->toArray();
        return view('backend.quan_ly_hd', compact('order_product', 'filters', 'search', 'dateFilter'));
    }

    //lọc đơn hàng theo ngày gần nhất và xa nhất
    function data_created_at(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $query = order_product::query();
        $dateOrder = $request->input('data_created_at', 'near');
        if ($dateOrder == 'near') {
            $query->orderByDesc('created_at');
        } else {
            $query->orderBy('created_at');
        }
        $order_product = $query->get()->toArray();
        $filters = [
            'status' => $request->input('status', 'all'),
            'loai' => $request->input('loai', 'all'),
            'dateOrder' => $dateOrder,
        ];
        $search = $request->input('search');
        $dateFilter = $request->input('dateFilter');
        $order_product = $query->get()->toArray();
        return view('backend.quan_ly_hd', compact('order_product', 'filters', 'search', 'dateFilter'));
    }

    //tìm kiếm hóa đơn
    function search_hd(Request $request) {
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $order_product = order_product::where('nameCustomer', 'LIKE', "%$search%")
                ->orWhere('order_code', 'LIKE', "%$search%")->orWhere('phoneCustomer', 'LIKE', "%$search%")
                ->get();
            if ($order_product->isEmpty()) {
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                $filters = array(
                    'status' => isset($_GET['status']) ? $_GET['status'] : 'all',
                    'loai' => isset($_GET['loai']) ? $_GET['loai'] : 'all'
                );
                $dateFilter = $request->input('dateFilter');
                return view('backend.quan_ly_hd', compact('order_product', 'filters', 'search', 'dateFilter'));
            }
        } else {
            return redirect()->back();
        }
    }

    // lọc ngày mua hóa đơn 
    function date_order_product(Request $request) {
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $dateFilter = $request->input('dateFilter');
        $pattern = '/^(\d{2}-\d{2}-\d{4}|\d{2}-\d{4}|\d{4})$/';
        if (preg_match($pattern, $dateFilter)) {
            $dateParts = explode('-', $dateFilter);
            if (count($dateParts) === 3) {
                $query = order_product::whereDate('created_at', '=', date('Y-m-d', strtotime($dateFilter)));
            } elseif (count($dateParts) === 2) {
                $query = order_product::whereYear('created_at', '=', $dateParts[1])
                    ->whereMonth('created_at', '=', $dateParts[0]);
            } else {
                $query = order_product::whereYear('created_at', '=', $dateFilter);
            }
            $order_product = $query->get();
            $filters = [
                'status' => $request->input('status', 'all'),
                'loai' => $request->input('loai', 'all')
            ];
            $search = $request->input('search');
            return view('backend.quan_ly_hd', [
                'order_product' => $order_product,
                'dateFilter' => $dateFilter,
                'search' => $search,
                'filters' => $filters
            ]);
        } else {
            return redirect()->route('quan-ly-hd')->with('message', 'Nhập không đúng định dạng');
        }
    }
    
    // in đơn hàng
    function print_order($checkout_code){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        return $pdf->stream();
    }

    function print_order_convert($checkout_code){
        $order_product = order_product::where('id', $checkout_code)->first();
        $infor_gas = json_decode($order_product->infor_gas, true);
        $output = '';
        $output .= '
            <style>
                body{
                    font-family: Dejavu Sans;
                }
                .table-thead{
                    margin-top: 10px;
                    border: 1px solid #000;
                }
                .table-thead th{
                    border: 1px solid #000;
                }
                .tbody-tr-td td{
                    width: 180px;
                    border: 1px solid #000;
                    text-align: center;
                }
                .thead-tr-name-table th{
                    width: 100px;
                    border: 1px solid #000;
                }
                .receipt-h3{
                    text-align: center;
                }
                td.product_name{
                    width: 180px;
                }
                td.quantity{
                    width: 50px;
                }
                td.product-price{
                    width: 120px;
                }
                .total-payment-price{
                    width: 150px;
                    text-align: center;
                }
                .bill-repeater{
                    float: right;
                }
                .bill-repeater-p{
                    text-align: center;
                }
            </style>
            <div class="receipt-h3">
                <h2>Gas Tech</h2>
                <span>Nhanh chóng - An toàn - Chất lượng - Hiệu quả</span>
                <p>SĐT 0837641469</p>
            </div>
            
            <h3 class="receipt-h3">HÓA ĐƠN THANH TOÁN</h3>
            <div class="infor-customer">
                <label class="name-add-product-all col-4" for="">Khách Hàng:</label>
                <span>'.$order_product['nameCustomer'].'</span>
            </div>

            <div class="">
                <label class="name-add-product-all col-4" for="">Địa chỉ:</label>
                <span>'.$order_product['diachi'].', '.$order_product['district'].', '.$order_product['state'].', '.$order_product['country'].'</span>
            </div>

            <div class="">
                <label class="name-add-product-all col-3" for="">Số điện thoại:</label>
                <span>'.$order_product['phoneCustomer'].'</span>
            </div>

            <div class="">
                <label class="name-add-product-all col-3" for="">Ngày đặt:</label>
                <span>'.$order_product['created_at'].'</span>
            </div>

            <div class="">
                <label class="name-add-product-all col-3" for="">Mã ĐH:</label>
                <span>'.$order_product['order_code'].'</span>
            </div>
            
            <table class="table-thead">
                <thead>
                    <tr class="thead-tr-name-table">
                        <th>Tên sản phẩm</th>
                        <th>SL</th>
                        <th>Giá</th>
                        <th>Giảm giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                    
                <tbody class="infor">';
            if (!empty($infor_gas)) {
                foreach ($infor_gas as $infor) {
                    $product = product::find($infor['product_id']);
                    if ($product) {
                        $output .= '
                            <tr class="tbody-tr-td">
                                <td class="product_name">'.$infor['product_name'].'</td>
                                <td class="quantity">'.$infor['quantity'].'</td>
                                <td class="product-price">'.number_format($infor['product_price']).' VNĐ</td>
                                <td class="product-price">'.number_format($order_product['reduced_value']).' VNĐ</td>';
                    }
                }
                $output .= '<div class="total-payment-price"><strong>'.number_format($order_product['tong']).' VNĐ</strong></div>
                </tr>';
            }
            $output .= '</tbody>
                        </table>
                        <p class="receipt-h3">Gas Tech xin chân thành cảm ơn quý khách,</p>
                        <p class="receipt-h3">Hẹn gặp lại!</p>
                        <div class="bill-repeater">
                            <p class="bill-repeater-p">Người lập</p>
                            <span>(ký, ghi họ tên)</span>
                        </div>
                        ';
            return $output;
    }

    //xuất file excel cho ds đơn hàng
    function export_excel(Request $request) {
        $search = $request->input('search');
        $dateFilter = $request->input('dateFilter');
        $orderQuery = order_product::query();
        if (!empty($search)) {
            $orderQuery->where(function ($query) use ($search) {
                $query->where('nameCustomer', 'LIKE', "%$search%")
                ->orWhere('order_code', 'LIKE', "%$search%");
            });
        }
    
        if (!empty($dateFilter)) {
            if (preg_match('/\d{2}-\d{2}-\d{4}/', $dateFilter)) {
                $dateParts = explode('-', $dateFilter);
                if (count($dateParts) === 3) {
                    $query = order_product::whereDate('created_at', '=', date('Y-m-d', strtotime($dateFilter)));
                } elseif (count($dateParts) === 2) {
                    $query = order_product::whereYear('created_at', '=', $dateParts[1])
                        ->whereMonth('created_at', '=', $dateParts[0]);
                } else {
                    $query = order_product::whereYear('created_at', '=', $dateFilter);
                }
            }
        }
        $order_product = $orderQuery->get();
        $status = $request->input('status', 'all');
        $loai = $request->input('loai', 'all');
        if ($order_product->isEmpty()) {
            return back()->with('message', 'Không có dữ liệu để xuất');
        } else {
            return Excel::download(new ExcelExports($status, $loai, $search, $dateFilter), 'ds_don_hang.xlsx');
        }
    }
    

    // trạng thái đơn hàng của admin
    function status_admin(Request $request, $id) {
        $order_product = order_product::find($id);
        if ($order_product) {
            if ($order_product->status != 3) {
                $order_product->status = $request->input('status');
                $order_product->save();
            }
            return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }

    // hủy giao hàng cho nhân viên
    function cancelDelivery($id) {
        $order_product = order_product::where('id', $id)->update(['admin_name' => 'Người giao hủy']);
        return redirect()->back();
    }

    // tìm kiếm hóa đơn cho nhân viên giao hàng
    function search_invoices_deliverie(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $admin_name = Session::get('admin')['admin_name'];     
            $order_product = order_product::where('admin_name', $admin_name)
            ->where(function($query) use ($search) {
                $query->where('nameCustomer', 'LIKE', "%$search%")
                      ->orWhere('order_code', 'LIKE', "%$search%");
            })->get();
            if ($order_product->isEmpty()) {
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                $filters = array(
                    'status' => isset($_GET['status']) ? $_GET['status'] : 'all',
                    'loai' => isset($_GET['loai']) ? $_GET['loai'] : 'all'
                );
                $dateFilter = $request->input('dateFilter');
                return view('backend.quan_ly_hd', compact('order_product', 'filters', 'search', 'dateFilter'));
            }
        } else {
            return redirect()->back();
        }
    }
}
