<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\order_product;
use App\Models\tbl_admin;
use App\Models\tbl_supplier;
use App\Models\product_warehouse;
use Session;
use App\Exports\ExcelExports_product;
use App\Exports\ExcelExports_warehouse;
use App\Exports\ExcelExports_inventory;
use App\Imports\Imports_product;
use App\Imports\Imports_warehouse;
use Excel;
class ProductController extends Controller
{
    // quản lý sản phẩm
    function quan_ly_sp(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $product = product::orderByDesc('id')->paginate(10);
        $filters = [
            'loai' => $request->input('loai', 'all')
        ];
        $search = $request->input('search');
        return view('backend.quan_ly_sp', ['product' => $product, 'filters' => $filters, 'search' => $search, ]);
    }

    // hiển thị giao diện chỉnh sửa sản phẩm
    function edit_product($id){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $product = product::find($id);
        return view('backend.edit_product', ['product' => $product]);
    }

    // cập nhật sản phẩm
    function update_product(Request $request, $id){
        $product = product::find($id);
        $product->name_product = $request->name_product;
        $product->loai = $request->loai;
        $product->unit = $request->unit;
        // $get_image = $request->image;
        $get_image = $request->image;
        if($get_image){
            // Bỏ hình ảnh cũ
            $path_unlink = 'uploads/product/'.$product->image;
            if(file_exists($path_unlink)){
                unlink($path_unlink);
            }
            // Thêm mới
            $path = 'uploads/product/';
            $get_name_image = $get_image-> getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image -> getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $product->image = $new_image;
        }
        $product->price = $request->price;
        $product->save();
        return redirect()->route('quan-ly-sp')->with('success', 'Cập nhật sản phẩm thành công');
    }

    // hiển thị giao diện thêm sản phẩm mới
    function add_product(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        return view('backend.add_product');
    }

    // xử lý thêm sản phẩm mới
    function add_products(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $data = $request->all();
        //    print_r($data);
        $product = new product;
        $product -> name_product = $data['name_product'];
        $product -> loai = $data['loai'];
        $product -> unit = $data['unit'];
        $product -> price =  0;
        $product -> quantity = 0;
        $product -> original_price =  0;
        $get_image = $request->image;
        $path = 'uploads/product/';
        $get_name_image = $get_image -> getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,99).'.'.$get_image -> getClientOriginalExtension();
        $get_image -> move($path,$new_image);
        $product -> image = $new_image;
        $product -> save();  
        return redirect()->route('quan-ly-sp')->with('success', 'Thêm sản phẩm thành công');
    }

    // xóa sản phẩm
    function delete_product($id){
        $product = product::find($id);
        $product -> delete();
        return redirect()->route('quan-ly-sp')->with('success', 'Xóa sản phẩm thành công');
    }

    // tìm kiếm sản phẩm
    function search_product(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $product = product::where('id', 'LIKE', "%$search%")->orWhere('name_product', 'LIKE', "%$search%")->get();
            if($product->isEmpty()){
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                $filters = array(
                    'loai' => $request->input('loai', 'all')
                );
                return view('backend.quan_ly_sp', compact('product', 'search', 'filters'));
            }
        } else {
            return redirect()->back();
        }
    }

    // quản lý nhập kho
    function quan_ly_kho(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $product_warehouse = product_warehouse::orderByDesc('created_at')->paginate(10);
        $productNames = [];
        foreach ($product_warehouse as $name) {
            $productNames[$name->product_id] = product::find($name->product_id)->name_product;
            $productUnit[$name->product_id] = product::find($name->product_id)->unit;
        }
        $admin_Names=[];
        foreach($product_warehouse as $name){
            $admin = tbl_admin::find($name->staff_id);
            if ($admin) {
                $admin_Names[$name->staff_id] = $admin->admin_name;
            }
        }
        $supplierNames = [];
        foreach ($product_warehouse as $name) {
            $supplier = tbl_supplier::find($name->supplier_id);
            if ($supplier) {
                $supplierNames[$name->supplier_id] = $supplier->name_supplier;
            }
        }
        $search = $request->input('search');
        $date_Filter_warehouse = $request->input('date_Filter_warehouse');
        $date_Filter_warehouse_end = $request->input('date_Filter_warehouse_end');
        $date_Filter_warehouse_start = $request->input('date_Filter_warehouse_start');
        return view('backend.quan_ly_kho', ['product_warehouse' => $product_warehouse,
        'productNames' => $productNames, 'admin_Names' => $admin_Names, 'search' => $search,
        'date_Filter_warehouse' => $date_Filter_warehouse, 'date_Filter_warehouse_end' => $date_Filter_warehouse_end,
        'date_Filter_warehouse_start' => $date_Filter_warehouse_start, 'productUnit' => $productUnit, 'supplierNames'=>$supplierNames
        ]);
    }

    //giao diện nhập kho sản phẩm
    function add_product_warehouse(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_product = product::get();
        $tbl_admin = tbl_admin::get();
        $tbl_supplier = tbl_supplier::get();
        $name_product = session()->get('name_product');
        $admin_name = session()->get('admin_name');
        return view('backend.add_product_warehouse', ['tbl_product' => $tbl_product, 'name_product' => $name_product,
            'tbl_admin' => $tbl_admin, 'admin_name' => $admin_name, 'tbl_supplier' => $tbl_supplier
        ]);
    }

    // nhập kho sản phẩm
    function add_warehouse(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $data = $request->all();
        $add_warehouse = new product_warehouse;
        $product_id = $request->input('product_id');
        $supplier_id = $request->input('supplier_id');
        $staff_id = $request->input('staff_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $add_warehouse -> product_id = $product_id;
        $add_warehouse -> supplier_id = $supplier_id;
        $add_warehouse -> staff_id = $staff_id;
        $add_warehouse -> quantity = $data['quantity'];
        $add_warehouse -> price = $data['price'];
        $add_warehouse -> batch_code = uniqid();
        $tong = $data['quantity'] * $data['price'];
        $add_warehouse -> total = $tong;
        $add_warehouse -> save();
        $product = product::find($product_id);
        if ($product) {
            $lastPurchasePrice = $price;
            $profitMargin = 0.3;
            $newSellingPrice = $lastPurchasePrice + ($lastPurchasePrice * $profitMargin); // tính giá bán
            $product->price = $newSellingPrice;
            $product->quantity += $quantity; // Cộng thêm số lượng mới vào số lượng hiện tại bên bảng product
            if ($product->original_price == 0) {
                $product->original_price = $price;
                $product->save();
            }
            $product->save();
        }
        return redirect()->route('quan-ly-kho')->with('success', 'Nhập sản phẩm thành công');
    }

    // tìm kiếm nhập kho 
    function search_warehouse(Request $request){
        if (!Session::get('admin')) {
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $productIds = product::where('name_product', 'LIKE', "%$search%")->pluck('id')->toArray();
            $staffIds = tbl_admin::where('admin_name', 'LIKE', "%$search%")->pluck('id')->toArray();
            $product_warehouse = product_warehouse::whereIn('product_id', $productIds)
                ->orWhereIn('staff_id', $staffIds)->orWhere('batch_code', 'LIKE', "%$search%")
                ->orWhere('product_id', 'LIKE', "%$search%")->get();
            $productNames = [];
            foreach ($product_warehouse as $name) {
                $productNames[$name->product_id] = product::find($name->product_id)->name_product;
                
            }
            $admin_Names = [];
            foreach ($product_warehouse as $name) {
                // $admin_Names[$name->staff_id] = tbl_admin::find($name->staff_id)->admin_name;
                $admin = tbl_admin::find($name->staff_id);
                if ($admin) {
                    $admin_Names[$name->staff_id] = $admin->admin_name;
                }
                $productUnit[$name->product_id] = product::find($name->product_id)->unit;
            }
            $supplierNames = [];
            foreach ($product_warehouse as $name) {
                $supplier = tbl_supplier::find($name->supplier_id);
                if ($supplier) {
                    $supplierNames[$name->supplier_id] = $supplier->name_supplier;
                }
            }
            if ($product_warehouse->isEmpty()) {
                return back()->with('message', 'Không tìm thấy kết quả');
            }else {
                $date_Filter_warehouse = $request->input('date_Filter_warehouse');
                $date_Filter_warehouse_start = $request->input('date_Filter_warehouse_start');
                $date_Filter_warehouse_end = $request->input('date_Filter_warehouse_end');
                return view('backend.quan_ly_kho', [
                    'product_warehouse' => $product_warehouse, 'search' => $search,
                    'productNames' => $productNames, 'admin_Names' => $admin_Names,
                    'date_Filter_warehouse' => $date_Filter_warehouse, 'date_Filter_warehouse_end' => $date_Filter_warehouse_end,
                    'date_Filter_warehouse_start' => $date_Filter_warehouse_start, 'productUnit' => $productUnit, 'supplierNames' => $supplierNames
                ]);
            }
        } else {
            return redirect()->back();
        }
    }

    //xóa nhập kho
    function delete_warehouse($id){
        $warehouse = product_warehouse::find($id);
        $warehouse -> delete();
        return redirect()->route('quan-ly-kho')->with('success', 'Xóa nhập kho thành công');
    }

    // quản lý tồn kho
    function quan_ly_ton_kho(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $product = product::orderByDesc('created_at')->paginate(10);
        $totalQuantityByProductId = product_warehouse::select('product_id', \DB::raw('sum(quantity) as total'))
            ->groupBy('product_id')->get();
        $totalQuantity = $totalQuantityByProductId->pluck('total', 'product_id')->toArray();
        $totalPriceProductId = product_warehouse::select('product_id', \DB::raw('sum(total) as total_price'))
            ->groupBy('product_id')->get();
        $totalPrice = $totalPriceProductId->pluck('total_price', 'product_id')->toArray();
        $quantity_sold = [];
        foreach ($product as $item) {
            $quantity_sold[$item->id] = ($totalQuantity[$item->id] ?? 0) - $item->quantity;
        }
        $search = $request->input('search');
        $filters = [
            'loai' => $request->input('loai', 'all')
        ];
        return view('backend.quan_ly_ton_kho', [
            'product' => $product, 'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice, 'quantity_sold' => $quantity_sold,
            'search' => $search, 'filters' => $filters
        ]);
    }

    // tìm kiếm tồn kho
    function search_inventory(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $product = product::get();
        $totalQuantityByProductId = product_warehouse::select('product_id', \DB::raw('sum(quantity) as total'))
            ->groupBy('product_id')->get();
        $totalQuantity = $totalQuantityByProductId->pluck('total', 'product_id')->toArray();
        $totalPriceProductId = product_warehouse::select('product_id', \DB::raw('sum(total) as total_price'))
            ->groupBy('product_id')->get();
        $totalPrice = $totalPriceProductId->pluck('total_price', 'product_id')->toArray();
        $quantity_sold = [];
        foreach ($product as $item) {
            $quantity_sold[$item->id] = ($totalQuantity[$item->id] ?? 0) - $item->quantity;
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $filters = [
                'loai' => $request->input('loai', 'all')
            ];
            $product = product::where('id', 'LIKE', "%$search%")->orWhere('name_product', 'LIKE', "%$search%")->get();
            if($product->isEmpty()){
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                return view('backend.quan_ly_ton_kho', ['product' => $product, 'search' => $search, 
                    'totalPrice' => $totalPrice, 'totalQuantity' => $totalQuantity, 
                    'quantity_sold' => $quantity_sold, 'filters' => $filters
                ]);
            }
        } else {
            return redirect()->back();
        }
    }

    // lọc sản phẩm theo loại
    function filters_product_type(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $product = product::get();
        $filters = [
            'loai' => $request->input('loai', 'all')
        ];
        $search = $request->input('search');
        return view('backend.quan_ly_sp', ['filters' => $filters, 'product' => $product, 'search' => $search,
        ]);
    }

    // xuất file excel cho ds kho sản phẩm
    function export_excel_product(Request $request) {
        $search = $request->input('search');
        $productQuery = product::query();
        if (!empty($search)) {
            $productQuery->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")->orWhere('name_product', 'LIKE', "%$search%");
            });
        }
        $product = $productQuery->get();
        $loai = $request->input('loai', 'all');
        if ($product->isEmpty()) {
            return back()->with('mesage', 'Không có dữ liệu để xuất');
        } else {
            return Excel::download(new ExcelExports_product($loai, $search), 'ds_san_pham.xlsx');
        }
    }

    // lọc theo khoảng thời gian cho nhập kho
    function filters_date_warehouse(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $date_Filter_warehouse = $request->input('date_Filter_warehouse');
        $date_Filter_warehouse_start = $request->input('date_Filter_warehouse_start');
        $date_Filter_warehouse_end = $request->input('date_Filter_warehouse_end');
        $pattern = '/^(\d{2}-\d{2}-\d{4}|\d{2}-\d{4}|\d{4})$/';
        if (!empty($date_Filter_warehouse_start) && !empty($date_Filter_warehouse_end)) {
            // Lọc theo khoảng thời gian
            if (preg_match($pattern, $date_Filter_warehouse_start) && preg_match($pattern, $date_Filter_warehouse_end)) {
                $startParts = explode('-', $date_Filter_warehouse_start);
                $endParts = explode('-', $date_Filter_warehouse_end);
                if (count($startParts) === 3 && count($endParts) === 3) {
                    $start = date('Y-m-d', strtotime($date_Filter_warehouse_start));
                    $end = date('Y-m-d', strtotime($date_Filter_warehouse_end .'+1 day'));
                    $query = product_warehouse::whereBetween('created_at', [$start, $end])->get();
                    // Lấy tên sản phẩm và tên người quản lý
                    $productNames = [];
                    $productUnit = [];
                    foreach ($query as $name) {
                        $productNames[$name->product_id] = product::find($name->product_id)->name_product;
                        $productUnit[$name->product_id] = product::find($name->product_id)->unit;
                    }
                    $admin_Names=[];
                    foreach($query as $name){
                        $admin = tbl_admin::find($name->staff_id);
                        if ($admin) {
                            $admin_Names[$name->staff_id] = $admin->admin_name;
                        }
                    }
                    $supplierNames = [];
                    foreach ($query as $name) {
                        $supplier = tbl_supplier::find($name->supplier_id);
                        if ($supplier) {
                            $supplierNames[$name->supplier_id] = $supplier->name_supplier;
                        }
                    }
                    foreach ($query as $record) {
                        $productNames[$record->product_id] = product::find($record->product_id)->name_product;
                        $admin = tbl_admin::find($name->staff_id);
                        if ($admin) {
                            $admin_Names[$name->staff_id] = $admin->admin_name;
                        }
                    }
                    $search = $request->input('search');
                    return view('backend.quan_ly_kho', [
                        'product_warehouse' => $query, 'date_Filter_warehouse' => $date_Filter_warehouse,
                        'date_Filter_warehouse_start' => $date_Filter_warehouse_start,
                        'date_Filter_warehouse_end' => $date_Filter_warehouse_end,
                        'search' => $search, 'productNames' => $productNames, 'admin_Names' => $admin_Names,
                        'productUnit' => $productUnit, 'supplierNames' => $supplierNames
                    ]);
                }
            }
        } else {
            // Lọc theo ngày/tháng/năm, tháng/năm hoặc năm
            if (preg_match($pattern, $date_Filter_warehouse)) {
                $dateParts = explode('-', $date_Filter_warehouse);
                if (count($dateParts) === 3) {
                    $query = product_warehouse::whereDate('created_at', '=', date('Y-m-d', strtotime($date_Filter_warehouse)));
                } elseif (count($dateParts) === 2) {
                    $query = product_warehouse::whereYear('created_at', '=', $dateParts[1])
                        ->whereMonth('created_at', '=', $dateParts[0]);
                } else {
                    $query = product_warehouse::whereYear('created_at', '=', $date_Filter_warehouse);
                }
                $product_warehouse = $query->get();
                $productNames = [];
                $productUnit = [];
                    foreach ($product_warehouse as $name) {
                        $productNames[$name->product_id] = product::find($name->product_id)->name_product;
                        $productUnit[$name->product_id] = product::find($name->product_id)->unit;
                    }
                $admin_Names=[];
                    foreach($product_warehouse as $name){
                        $admin = tbl_admin::find($name->staff_id);
                        if ($admin) {
                            $admin_Names[$name->staff_id] = $admin->admin_name;
                        }
                    }
                $supplierNames = [];
                    foreach ($product_warehouse as $name) {
                        $supplier = tbl_supplier::find($name->supplier_id);
                        if ($supplier) {
                            $supplierNames[$name->supplier_id] = $supplier->name_supplier;
                        }
                    }
                $search = $request->input('search');
                $date_Filter_warehouse_end = $request->input('date_Filter_warehouse_end');
                $date_Filter_warehouse_start = $request->input('date_Filter_warehouse_start');
                return view('backend.quan_ly_kho', [
                    'product_warehouse' => $query, 'product_warehouse' => $product_warehouse,
                    'date_Filter_warehouse' => $date_Filter_warehouse,
                    'date_Filter_warehouse_end' => $date_Filter_warehouse_end,
                    'date_Filter_warehouse_start' => $date_Filter_warehouse_start,
                    'search' => $search, 'productNames' => $productNames, 'admin_Names' => $admin_Names,
                    'supplierNames' => $supplierNames, 'productUnit' => $productUnit
                ]);
            }
        }
        return redirect()->route('quan-ly-kho')->with('message', 'Nhập không đúng định dạng');
    }

    // xuất file excel cho nhập kho
    function export_excel_warehouse(Request $request) {
        $search = $request->input('search');
        $date_Filter_warehouse = $request->input('date_Filter_warehouse');
        $date_Filter_warehouse_start = $request->input('date_Filter_warehouse_start');
        $date_Filter_warehouse_end = $request->input('date_Filter_warehouse_end');
        $productIds = product::where('name_product', 'LIKE', "%$search%")->pluck('id')->toArray();
        $staffIds = tbl_admin::where('admin_name', 'LIKE', "%$search%")->pluck('id')->toArray();
        $pattern = '/^(\d{2}-\d{2}-\d{4}|\d{2}-\d{4}|\d{4})$/';
        $productQuery = product_warehouse::query();
        $product_warehouse = product_warehouse::whereIn('product_id', $productIds)
            ->orWhereIn('staff_id', $staffIds)->orWhere('batch_code', 'LIKE', "%$search%")
            ->orWhere('product_id', 'LIKE', "%$search%")->get();
        if (!empty($date_Filter_warehouse_start) && !empty($date_Filter_warehouse_end)) {
            if (preg_match($pattern, $date_Filter_warehouse_start) && preg_match($pattern, $date_Filter_warehouse_end)) {
                $startParts = explode('-', $date_Filter_warehouse_start);
                $endParts = explode('-', $date_Filter_warehouse_end);
                if (count($startParts) === 3 && count($endParts) === 3) {
                    $start = date('Y-m-d', strtotime($date_Filter_warehouse_start));
                    $end = date('Y-m-d', strtotime($date_Filter_warehouse_end .'+1 day'));
                    $productQuery->whereBetween('created_at', [$start, $end]);
                }
            }
        }
        if (!empty($date_Filter_warehouse)) {
            if (preg_match($pattern, $date_Filter_warehouse)) {
                $dateParts = explode('-', $date_Filter_warehouse);
                if (count($dateParts) === 3) {
                    $productQuery->whereDate('created_at', '=', date('Y-m-d', strtotime($date_Filter_warehouse)));
                } elseif (count($dateParts) === 2) {
                    $productQuery->whereYear('created_at', '=', $dateParts[1])
                        ->whereMonth('created_at', '=', $dateParts[0]);
                } else {
                    $productQuery->whereYear('created_at', '=', $date_Filter_warehouse);
                }
            }
        }
        $product_warehouse = $productQuery->get();
        if ($product_warehouse->isEmpty()) {
            return back()->with('message', 'Không có dữ liệu để xuất');
        } else {
            return Excel::download(new ExcelExports_warehouse($date_Filter_warehouse, $search, $productIds, $staffIds,
                $date_Filter_warehouse_start, $date_Filter_warehouse_end
            ), 'ds_nhap_kho_san_pham.xlsx');
        }
    }

    // lọc theo loại cho tồn kho
    function filters_inventory_type(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $product = product::get();
        $filters = [
            'loai' => $request->input('loai', 'all')
        ];
        $search = $request->input('search');
        $totalQuantityByProductId = product_warehouse::select('product_id', \DB::raw('sum(quantity) as total'))
            ->groupBy('product_id')->get();
        $totalQuantity = $totalQuantityByProductId->pluck('total', 'product_id')->toArray();
        $totalPriceProductId = product_warehouse::select('product_id', \DB::raw('sum(total) as total_price'))
            ->groupBy('product_id')->get();
        $totalPrice = $totalPriceProductId->pluck('total_price', 'product_id')->toArray();
        $quantity_sold = [];
        foreach ($product as $item) {
            $quantity_sold[$item->id] = ($totalQuantity[$item->id] ?? 0) - $item->quantity;
        }
        return view('backend.quan_ly_ton_kho', ['product' => $product, 'search' => $search, 
            'totalPrice' => $totalPrice, 'totalQuantity' => $totalQuantity, 
            'quantity_sold' => $quantity_sold, 'filters' => $filters
        ]);
    }

    // Xuất excel cho tồn kho
    function export_excel_inventory(Request $request){
        $search = $request->input('search');
        $loai = $request->input('loai', 'all');
        $productQuery = product::query()
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('id', 'LIKE', "%$search%")
                        ->orWhere('name_product', 'LIKE', "%$search%");
                });
            });
        $product = $productQuery->get();
        if ($product->isEmpty()) {
            return back()->with('message', 'Không có dữ liệu để xuất');
        } else {
            $totalQuantityByProductId = product_warehouse::select('product_id', \DB::raw('sum(quantity) as total'))
                ->groupBy('product_id')->get();
            $totalQuantity = $totalQuantityByProductId->pluck('total', 'product_id')->toArray();
            $totalPriceProductId = product_warehouse::select('product_id', \DB::raw('sum(total) as total_price'))
                ->groupBy('product_id')->get();
            $totalPrice = $totalPriceProductId->pluck('total_price', 'product_id')->toArray();
            $quantity_sold = [];
            foreach ($product as $item) {
                $quantity_sold[$item->id] = ($totalQuantity[$item->id] ?? 0) - $item->quantity;
            }
            return Excel::download(new ExcelExports_inventory($loai, $search, $totalQuantity, $totalPrice, $quantity_sold, $product), 'ds_ton_kho_sp.xlsx');
        }
    }

    // import file excel cho sản phẩm
    function import_excel_product(Request $request){
        try {
            $path = $request->file('file')->getRealPath();
            Excel::import(new Imports_product, $path);
            return redirect()->route('quan-ly-sp')->with('success', 'Import file thành công');
        } catch (\Exception $e) {
            return redirect()->route('quan-ly-sp')->with('message', 'Lỗi Import file');
        }
    }

    // import file excel cho nhập kho sản phẩm
    function import_excel_warehouse(Request $request){
        try {
            $path = $request->file('file')->getRealPath();
            Excel::import(new Imports_warehouse, $path);
            return redirect()->route('quan-ly-kho')->with('success', 'Import file thành công');
        } catch (\Exception $e) {
            return redirect()->route('quan-ly-kho')->with('message', 'Lỗi Import file');
        }
    }


    // nhà cung cấp gas
    function nha_cung_cap_gas(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_supplier = tbl_supplier::get();
        return view('backend.nha_cung_cap_gas', ['tbl_supplier' => $tbl_supplier]);
    }

    // giao diện thêm nhà cung cấp gas
    function add_supplier(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        return view('backend.add_supplier');
    }

    // xử lý nhà cung cấp
    function add_suppliers(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $data = $request->all();
        $tbl_supplier = new tbl_supplier();
        $tbl_supplier -> name_supplier = $data['name_supplier'];
        $tbl_supplier ->save();
        return redirect()->route('nha-cung-cap')->with('success', 'Thêm nhà cung cấp thành công');
    }

    // giao diện chỉnh sửa nhà cung cấp
    function edit_suppliers($id){
        $tbl_supplier = tbl_supplier::find($id);
        return view('backend.edit_suppliers', ['tbl_supplier' => $tbl_supplier]);
    }

    // xử lý nhà cung cấp
    function update_suppliers(Request $request, $id){
        $tbl_supplier = tbl_supplier::find($id);
        $tbl_supplier->name_supplier = $request->name_supplier;
        $tbl_supplier->save();
        return redirect()->route('nha-cung-cap')->with('success', 'Cập nhật nhà cung cấp thành công');
    }

    // tìm kiếm nhà cung cấp 
    function searchsuppliers(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $tbl_supplier = tbl_supplier::where('id', 'LIKE', "%$search%")->orWhere('name_supplier', 'LIKE', "%$search%")->get();
            if($tbl_supplier->isEmpty()){
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                return view('backend.nha_cung_cap_gas', compact('tbl_supplier', 'search'));
            }
        } else {
            return redirect()->back();
        }
    }

    function delete_supplier($id){
        $tbl_supplier = tbl_supplier::find($id);
        $tbl_supplier -> delete();
        return redirect()->route('nha-cung-cap')->with('success', 'Xóa nhà cung cấp thành công');
    }

}