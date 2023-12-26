<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\add_staff;
use App\Models\tbl_admin;
use App\Models\order_product;
use App\Exports\ExcelExports;
use App\Exports\ExcelExportsStaff;
use Excel;
class StaffController extends Controller
{
    // giao diện quản lý nhân viên 
    function quan_ly_nv(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $staff = add_staff::paginate(8);
        return view('backend.quan_ly_nv',['staff' => $staff]);
    }

    // giao diện edit nhân viên
    function edit_staff($id){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $staff = add_staff::find($id);
        //    echo " <pre>";
        //    print_r($staff);
        return view('backend.edit_staff' , ['staff' => $staff]);
    }

    // cập nhật nhân viên
    function update_staff(Request $request, $id){
        $staff = add_staff::find($id);
        $staff->last_name = $request->last_name;
        $staff->birth = $request->birth;
        $staff->chuc_vu = $request->chuc_vu;
        $staff->taikhoan = $request->taikhoan;
        $staff->dia_chi = $request->dia_chi;
        $staff->date_input = $request->date_input;
        $staff->phone = $request->phone;
        $staff->CCCD = $request->CCCD;
        $staff->luong = $request->luong;
        $staff->gioi_tinh = $request->gioi_tinh;
        $get_image = $request->image_staff;
        if($get_image){
            // Bỏ hình ảnh cũ
            $path_unlink = 'uploads/staff/'.$staff->image_staff;
            if($staff->image_staff && file_exists($path_unlink)){
                unlink($path_unlink);
            }
            // Thêm mới
            $path = 'uploads/staff/';
            $get_name_image = $get_image-> getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image -> getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $staff->image_staff = $new_image;
        }
        $staff->save();
        return redirect()->route('quan-ly-nv')->with('success', 'Cập nhật nhân viên thành công');;
    }

    // trang thêm nv
    function add_staff(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        return view('backend.add_staff');
    }

    // thêm nv
    function staff_add(Request $request){
        $data = $request->all();
        $add_staff = new add_staff;
        $add_staff->last_name = $data['last_name'];
        $add_staff->birth =  $data['birth'];
        $add_staff->chuc_vu = $data['chuc_vu'];
        $add_staff->dia_chi = $data['dia_chi'];
        $add_staff->taikhoan = $data['taikhoan'];
        $add_staff->date_input = $data['date_input'];
        $add_staff->phone = $data['phone'];
        $add_staff->luong = $data['luong'];
        $add_staff->CCCD = $data['CCCD'];
        $add_staff->gioi_tinh = $data['gioi_tinh'];
        $add_staff->status_add = false;
        $image = $request->file('image_staff');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/uploads/staff');
        $image->move($destinationPath, $name);
        $add_staff->image_staff = $name;
        // print_r($get_image);die;
        $add_staff -> save();  
        return redirect()->route('quan-ly-nv')->with('success', 'Thêm nhân viên thành công');
    }

    // xóa nv
    function delete_staff($id){
        $staff_add = add_staff::find($id);
        $staff_add->delete();
        return redirect()->route('quan-ly-nv')->with('success','Xóa nhân viên thành công');
    }

    // tìm kiếm nhân viên
    function searchStaff(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $staff = add_staff::where('id', 'LIKE', "%$search%")->orWhere('last_name', 'LIKE', "%$search%")->paginate(6);
            if(empty($staff->items())){
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                return view('backend.quan_ly_nv', ['staff' => $staff, 'search' => $search]);
            }
        } else {
            return redirect()->back();
        }
    }

    // xuất file excel cho ds nhân viên
    function export_excel_staff(){
        return Excel::download(new ExcelExportsStaff , 'ds_nhan_vien.xlsx');
    }

    // giao diện nhân viên giao hàng
    function nhan_vien_giao_hang(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_admin = tbl_admin::where('chuc_vu','1')->get()->toArray();
        $staff = add_staff::get()->toArray();
        $date_Filter = $request->input('date_Filter');
        $date_Filter_start = $request->input('date_Filter_start');
        $date_Filter_end = $request->input('date_Filter_end');
        foreach ($tbl_admin as &$tbl_admins) {
            $admin_name = $tbl_admins['admin_name'];
            $order_count = order_product::where('admin_name', $admin_name)->count();
            $total_sales = order_product::where('admin_name', $admin_name)->sum('tong');
            $tbl_admins['order_count'] = $order_count;
            $tbl_admins['total_sales'] = $total_sales;
        }
        return view('backend.nhan_vien_giao_hang', ['tbl_admin' => $tbl_admin, 'staff' =>$staff, 
        'date_Filter' => $date_Filter, 'date_Filter_start' => $date_Filter_start, 'date_Filter_end' => $date_Filter_end]);
    }

    // lọc số đơn giao theo ngày tháng năm nhân viên giao hàng
    function data_filter_shiper(Request $request){
        if (!Session::get('admin')) {
            return redirect()->route('login');
        }
        $tbl_admin = tbl_admin::where('chuc_vu', '1')->get();
        $staff = add_staff::get();
        $date_Filter = $request->input('date_Filter');
        $date_Filter_start = $request->input('date_Filter_start');
        $date_Filter_end = $request->input('date_Filter_end');
        foreach ($tbl_admin as &$tbl_admins) {
            $admin_name = $tbl_admins->admin_name;
            $query = order_product::where('admin_name', $admin_name);
            if (!empty($date_Filter)) {
                $dateParts = explode('-', $date_Filter);
                if (count($dateParts) == 3) {
                    $year = $dateParts[2];
                    $month = $dateParts[1];
                    $day = $dateParts[0];
                    $query->whereDate('created_at', date('Y-m-d', strtotime("$year-$month-$day")));
                } elseif (count($dateParts) == 2) {
                    $year = $dateParts[1];
                    $month = $dateParts[0];
                    $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
                } elseif (count($dateParts) == 1) {
                    $year = $dateParts[0];
                    $query->whereYear('created_at', $year);
                }
            }
            // Lọc theo khoảng thời gian
            if (!empty($date_Filter_start) && !empty($date_Filter_end)) {
                $query->whereBetween('created_at', [
                    date('Y-m-d', strtotime($date_Filter_start)),
                    date('Y-m-d', strtotime($date_Filter_end)),
                ]);
            }
            $order_count = $query->count();
            $total_sales = $query->sum('tong');
            $tbl_admins->order_count = $order_count;
            $tbl_admins->total_sales = $total_sales;
        }
        return view('backend.nhan_vien_giao_hang', ['tbl_admin' => $tbl_admin, 'date_Filter' => $date_Filter,
        'date_Filter_start' => $date_Filter_start, 'date_Filter_end' => $date_Filter_end]);
    }
    
    

}
