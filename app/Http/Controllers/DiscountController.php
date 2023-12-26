<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_discount;
use App\Models\order_product;
use App\Models\users;
use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
class DiscountController extends Controller
{
    // quản lý giảm giá
    function quan_ly_giam_gia(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        // cập nhật lại trạng thái khi hết hạn
        $this->update_status_discount($request);
        $tbl_discount = tbl_discount::orderByDesc('created_at')->get()->toArray();
        return view('backend.quan_ly_giam_gia', ['tbl_discount' => $tbl_discount]);
    }

    // giao diện thêm mã giảm
    function add_discount(){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        return view('backend.add_discount');
    }
    
    // thêm mã mới
    function add_discounts(Request $request){
        $data = $request -> all();
        $add_discount = new tbl_discount;
        $add_discount -> name_voucher = $data['name_voucher'];
        $add_discount -> ma_giam = $data['ma_giam'];
        $add_discount -> so_luong = $data['so_luong'];
        $add_discount -> gia_tri = $data['gia_tri'];
        $add_discount -> thoi_gian_giam = $data['thoi_gian_giam'];
        $add_discount -> het_han = $data['het_han'];
        $add_discount -> type = $data['type'];
        $add_discount -> Prerequisites = $data['Prerequisites'];
        $add_discount->status = 1;
        $add_discount -> save(); 
        $customers = users::where('email', '<>', '')->get();
        // Gửi email cho từng khách hàng
        foreach ($customers as $customer) {
            if (!empty($customer->email)){
                Mail::send('backend.send_mail_discount', compact('add_discount', 'customer'), function($email) use($customer) {
                    $email->subject('Thông báo mã giảm giá mới');
                    $email->to($customer->email, $customer->name);
                });
            }
        }
        return redirect()->route('quan-ly-giam-gia')->with('success', 'Thêm mã giảm giá thành công');
    }

    // giao diện edit thêm mã giảm 
    function edit_discount($id){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $tbl_discount = tbl_discount::find($id);
        return view('backend.edit_discount', ['tbl_discount' => $tbl_discount]);
    }

    // cập nhật mã mới
    function update_discounts(Request $request, $id){
        $tbl_discount = tbl_discount::find($id);
        $tbl_discount -> name_voucher = $request -> name_voucher;
        $tbl_discount -> ma_giam = $request -> ma_giam;
        $tbl_discount -> so_luong = $request -> so_luong;
        $tbl_discount -> gia_tri = $request -> gia_tri;
        $tbl_discount -> thoi_gian_giam = $request -> thoi_gian_giam;
        $tbl_discount -> het_han = $request -> het_han;
        $tbl_discount -> type = $request -> type;
        $tbl_discount -> Prerequisites = $request -> Prerequisites;
        $tbl_discount -> save();
        return redirect()->route('quan-ly-giam-gia')->with('success', 'Cập nhật mã giảm giá thành công');
    }

    // tìm kiếm mã giảm giá
    function searchDiscount(Request $request){
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        if ($request->isMethod('get')) {
            $search = $request->input('search');
            $tbl_discount = tbl_discount::where('ma_giam', 'LIKE', "%$search%")->orWhere('name_voucher', 'LIKE', "%$search%")->paginate(10);
            if(empty($tbl_discount->items())){
                return back()->with('message', 'Không tìm thấy kết quả');
            } else {
                return view('backend.quan_ly_giam_gia', ['tbl_discount' => $tbl_discount, 'search' => $search]);
            }
        } else {
            return redirect()->back();
        }
    }

    // cập nhật trạng thái giảm giá khi hết hạn
    function update_status_discount(Request $request) {
        $discounts = tbl_discount::where('status', 1)->get();
        foreach ($discounts as $discount) {
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $discount->het_han);
            $currentDate = Carbon::now();
            if ($currentDate->gte($endDate)) {
                $discount->status = 2;
                $discount->save();
            }
        }
    }

    // xóa mã giảm giá 
    function delete_discount($id){
        $tbl_discount = tbl_discount::find($id);
        $tbl_discount -> delete();
        return redirect()->route('quan-ly-giam-gia')->with('success', 'Xóa mã giảm giá thành công');
    }
    
    // kiểm tra mã giảm giá
    function check_coupon(Request $request) {
        if(!Session::get('admin')){
            return redirect()->route('login');
        }
        $couponCode = $request->input('coupon');
        $coupon = tbl_discount::where('ma_giam', $couponCode)->first();
        if ($coupon) {
            $userId = Session::get('home')['id'];
            if ($userId) {
                $usedInOrder = order_product::where('user_id', $userId)
                    ->where('coupon', $couponCode)
                    ->exists();
                return response()->json([
                    'success' => true,
                    'used' => $usedInOrder,
                    'type' => $coupon->type,
                    'gia_tri' => $coupon->gia_tri,
                    'so_luong' => $coupon->so_luong,
                    'status' => $coupon->status,
                    'Prerequisites' => $coupon->Prerequisites
                ]);
            }
            return response()->json([
                'success' => true,
                'used' => false,
                'type' => $coupon->type,
                'gia_tri' => $coupon->gia_tri,
                'so_luong' => $coupon->so_luong,
                'status' => $coupon->status,
                'Prerequisites' => $coupon->Prerequisites
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    // thông báo số lượng giảm giá
    function notification_discount_quantity(Request $request){
        $couponCode = $request->input('coupon');
        $coupon = tbl_discount::where('ma_giam', $couponCode)->first();
        return redirect()->back();
    }
}
