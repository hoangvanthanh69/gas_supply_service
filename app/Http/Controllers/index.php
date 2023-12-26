<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order_product;
use App\Models\product;
use App\Models\tbl_admin;
use App\Models\tbl_discount;
use App\Models\tbl_vnpay;
use App\Models\users;
use App\Models\tbl_comment;
use App\Models\tbl_message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\danh_gia;
// use Illuminate\Support\Facades\Session;
use DB;
use Session;
use Mail;
class index extends Controller
{
   function home(){
      if (!Session::get('home')) {
         return redirect()->route('dangnhap');
      }
      $user_id = Session::get('home')['id'];
      $order_product = order_product::where('user_id', $user_id)->get()->toArray();
      $phoneCustomer = null;
      $diachi = null;
      $country = null;
      $state = null;
      $district = null;
      if (!empty($order_product)) {
         usort($order_product, function($a, $b) {
            return strcmp($b['created_at'], $a['created_at']);
         });
         $phoneCustomer = $order_product[0]['phoneCustomer'];
         $diachi = $order_product[0]['diachi'];
         $country = $order_product[0]['country'];
         $state = $order_product[0]['state'];
         $district = $order_product[0]['district'];
      } 
      elseif (empty($order_product) && Session::has('phoneCustomer', 'diachi', 'country', 'state', 'district')) {
         $phoneCustomer = Session::get('phoneCustomer');
         $diachi = Session::get('diachi');
         $country = Session::get('country');
         $state = Session::get('state');
         $district = Session::get('district');
      }
      $users = users::find($user_id);
      $counts_processing = order_product::where('user_id', $user_id)->count();
      $products = product::where('price', '>', 0)->get(); // chỉ hiển thị những sản phẩm có giá lớn hơn 0
      $tbl_discount = tbl_discount::get();
      $ma_giam = session()->get('ma_giam');
      $ma_giam = session()->get('gia_tri');
      return view('frontend.home', ['order_product' => $order_product, 'phoneCustomer' => $phoneCustomer,
         'diachi' => $diachi, 'country' => $country, 'state' => $state, 'district' => $district, 
         'users' => $users,'counts_processing' => $counts_processing,'products' => $products,
         'ma_giam' => $ma_giam, 'tbl_discount' => $tbl_discount,
      ]);
   }

   function order(){
      echo "<pre>"; 
      print_r(Session::get('idProduct'));
      print_r($_POST['nameCustomer']);
      print_r($_POST['phoneCustomer']);
      print_r($_POST['country']);
      print_r($_POST['state']);
      print_r($_POST['district']);
      print_r($_POST['diachi']);
      print_r($_POST['amount']);
      print_r($_POST['ghichu']);
      print_r($_POST['type']);
      print_r($_POST['name_product']);
      print_r($_POST['original_price']);
      print_r($_POST['image']);
   }

   function order_product(Request $request){
      $paymentOption = $request->input('paymentOption');
      $inforGas = $request->input('infor_gas');
      $data = [];
      $totalPrice = 0;
      foreach ($inforGas as $productId => $quantity) {
         if ($quantity) {
            $product = product::find($productId);
            if ($product) {
               $price = $product->price;
               $totalPrice += $price * $quantity;
               $data[] = [
                  'product_id' => $productId,
                  'product_name' => $product->name_product,
                  'product_price' => $price,
                  'quantity' => $quantity,
               ];
               // Kiểm tra số lượng sản phẩm đủ để đặt hàng hay không
               $current_quantity = $product->quantity;
               $new_quantity = $current_quantity - $quantity;
               if ($new_quantity < 0) {
                  return redirect()->route('home')->with('mesage', 'Sản phẩm ' . $product->name_product . ' không đủ số lượng');
               }
               // Cập nhật số lượng sản phẩm
               $product->quantity = $new_quantity;
               $product->save();
            }
         }
      }
      $jsonData = json_encode($data);
      $order = new order_product;
      $order->infor_gas = $jsonData;
      Session::put('phoneCustomer', $request['phoneCustomer']);
      Session::put('country', $request['country']);
      Session::put('diachi', $request['diachi']);
      Session::put('state', $request['state']);
      Session::put('district', $request['district']);
      $order->nameCustomer = $request['nameCustomer'];
      $order->phoneCustomer = $request['phoneCustomer'];
      $order->country = $request['country'];
      $order->state = $request['state'];
      $order->district = $request['district'];
      $order->diachi = $request['diachi'];
      $order->loai = $request['loai'];
      $user_id = Session::get('home')['id'];
      $order->user_id = $user_id;
      if (empty($request['ghichu'])) {
         $order->ghichu = 'null';
      } else {
         $order->ghichu = $request['ghichu'];
      }
      $order->status = 1;
      if (isset($admin_name)) {
         $order->admin_name = $admin_name;
      } else {
         $order->admin_name = 'Chưa có người giao';
      }
      $order->order_code = uniqid();
      // $order->tong = $totalPrice;
      $tong = $request->input('tong');
      $order->tong = $tong;
      $reduced_value = $request->input('reduced_value');
      $order->reduced_value = $reduced_value;
      if ($request->has('coupon')) {
         $couponCode = $request->input('coupon');
         $coupon = tbl_discount::where('ma_giam', $couponCode)->first();
         if ($coupon) {
            // Áp dụng mã giảm giá vào đơn hàng
            $order->coupon = $couponCode;
            $order->save();
            $this->update_discount_quantity($couponCode);
         }
      }
      $order->payment_status = 1;
      $order->save();
      $orderId = $order->id;
      $user = users::find($user_id);

      // dd($user);
      if (!empty($user->email)) {
         Mail::send('backend.send_mail_order', compact('order', 'user'), function($email) use($user) {
            $email->subject('Đặt hàng thành công');
            $email->to($user->email, $user->name);
         });
      }
      if ($paymentOption == "vnpay") {
         $this->vnpay_payment($orderId);
      }
      return redirect()->route('home')->with('success', 'Đặt giao gas thành công');
   }

   // cập nhật số lượng mã giảm giá
   function update_discount_quantity($couponCode) {
      $coupon = tbl_discount::where('ma_giam', $couponCode)->first();
      if ($coupon) {
         $newQuantity = $coupon->so_luong - 1;
         $coupon->update(['so_luong' => $newQuantity]);
      }
   }

   // hủy đơn hàng của khách hàng
   function cancelOrder($id) {
      $order_product = order_product::find($id);
      $product_infor = $order_product->infor_gas;
      if ($product_infor) {
         $product_data = json_decode($product_infor, true);
         $product_ids = [];
         $product_quantities = [];
         if (is_array($product_data) && count($product_data) > 0) {
            foreach ($product_data as $product) {
               $product_id = $product['product_id'];
               $quantity = $product['quantity'];
               $product_ids[] = $product_id;
               $product_quantities[$product_id] = $quantity; // Lưu số lượng cho từng sản phẩm
               // dd($product_ids);
            }
         }
         $products = product::whereIn('id', $product_ids)->get();
         foreach ($products as $product) {
            $product_id = $product->id;
            $quantity = $product_quantities[$product_id];
            // Cập nhật số lượng của sản phẩm
            $product->quantity += $quantity;
            $product->save();
         }
         // Đánh dấu đơn hàng là đã hủy
         $order_product->status = 4; // Đã hủy
         $order_product->save();
         return redirect()->route('order-history')->with('message', 'Đã hủy đơn hàng thành công');
      } else {
         return redirect()->route('order-history')->with('message', 'Không tìm thấy đơn hàng');
      }
   }

   function getProductByID(Request $request){
      $productID = $request->input('productID');
      $product = product::find($productID);
      if ($product) {
         return response()->json([
            'success' => true,
            'product' => $product
         ]);
      }
      return response()->json([
         'success' => false,
         'message' => 'Không tìm thấy sản phẩm'
      ]);
   }

   //
   function order_history(Request $request) {
      if (!Session::get('home')) {
         return redirect()->route('dangnhap');
      }
      $user_id = Session::get('home')['id'];
      $order_product = order_product::orderByDesc('created_at')->where('user_id', $user_id);
      $status = isset($_GET['status']) ? $_GET['status'] : 'all';
      $users = users::find($user_id);
      $counts_processing = order_product::where('user_id', $user_id)->where('status', 1)->count();
      $counts_delivery = order_product::where('user_id', $user_id)->where('status', 2)->count();
      $counts_all = order_product::where('user_id', $user_id)->count();
      $counts_complete = order_product::where('user_id', $user_id)->where('status', 3)->count();
      $counts_cancel = order_product::where('user_id', $user_id)->where('status', 4)->count();
      // Lọc theo ngày
      $filter = $request->input('filter');
      $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
      if ($filter == '5') {
         $order_product->whereDate('created_at', '>=', now()->subDays(5));
      } elseif ($filter == '10') {
         $order_product->whereDate('created_at', '>=', now()->subDays(10));
      } elseif ($filter == '30') {
         $order_product->whereDate('created_at', '>=', now()->subDays(30));
      } elseif ($filter == '180') {
         $order_product->whereDate('created_at', '>=', now()->subMonths(6));
      }
      $order_product = $order_product->get()->toArray();
      foreach ($order_product as &$order) {
         $infor_gas = json_decode($order['infor_gas'], true);
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
         $order['products'] = $products;
      }
      return view('frontend.order_history', ['order_product' => $order_product,'status' => $status,
         'counts_processing' => $counts_processing, 'counts_all' => $counts_all,
         'counts_delivery' => $counts_delivery, 'counts_complete' => $counts_complete, 
         'counts_cancel' => $counts_cancel,'filter' => $filter,
      ]);
   }

   // thông tin đơn hàng của khách hàng
   function thong_tin_don_hang(Request $request, $id){
      if(!Session::get('home')){
         return redirect()->route('dangnhap');
      }
      $order_product = order_product::find($id);
      if (!$order_product) {
         return redirect()->route('order_history')->with('error', 'Không tìm thấy đơn hàng.');
      }
      $delivery_info = tbl_admin::where('admin_name', $order_product->admin_name)->first();
      if($delivery_info) {
         $staff_id = $delivery_info->id;
      } else {
         $staff_id = null;
      }
      $user_id = $order_product->user_id;
      $danh_gia = danh_gia::where('staff_id', $staff_id)
         ->where('user_id', $user_id)
         ->where('order_id', $id)
         ->first();
      $ratings = danh_gia::where('staff_id', $staff_id)->pluck('rating');
      $total_stars = $ratings->sum();
      $count_ratings = count($ratings);
      $average_rating = $count_ratings > 0 ? $total_stars / $count_ratings : 0;
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
      $productCount = count($products);
      $id_customer = Session::get('home')['id'];
      $customer = users::find($id_customer);
      // print($productCount); die;
      $counts_comment = tbl_comment::where('staff_id', $staff_id)->where('status_comment',0)->count();
      return view('frontend.thong_tin_don_hang', [ 'order_product' => $order_product,
         'delivery_info' => $delivery_info, 'danh_gia' => $danh_gia, 'average_rating' => $average_rating,
         'staff_id' => $staff_id, 'products' => $products, 'productCount' => $productCount, 'customer' => $customer,
         'counts_comment' => $counts_comment
      ]);
   }
    
   function danh_gia_giao_hangs(Request $request, $id){
      $user_id = Session::get('home')['id'];
      $staff_id = $request->input('staff_id');
      $order_id = $request->input('order_id');
      $Comment = $request->input('Comment');
      $rating = $request->input('rating');
      $new_rating = new danh_gia;
      $new_rating->staff_id = $staff_id;
      $new_rating->order_id = $order_id;
      $new_rating->user_id = $user_id;
      // $new_rating->Comment = $Comment;
      if(empty($request['Comment'])){
         $new_rating->Comment = 'null';
      }else {
         $new_rating->Comment =$request['Comment'];
      }
      $new_rating->rating = $rating; 
      $new_rating->save();
      return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá');
   }

   // cap nhat anh cho khach hang
   function update_image_user(Request $request, $id) {
      $user = users::find($id);
      if ($request->hasFile('img')) {
         $image = $request->file('img');
         $name = time() . '.' . $image->getClientOriginalExtension();
         $destinationPath = public_path('/uploads/users');
         $image->move($destinationPath, $name);
         $user->img = $name;
         $user->save();
      }
      $phone = $request->input('phone');
      $email = $request->input('email');
      $existingPhoneUser = users::where('phone', $phone)->where('id', '!=', $id)->first();
      if ($email) { 
         $existingEmailUser = users::where('email', $email)->where('id', '!=', $id)->first();
         if ($existingEmailUser) {
            return redirect()->back()->with('mesage', 'Email đã tồn tại, Vui lòng sử dụng email khác.');
         }
      }
      if ($existingPhoneUser) {
         return redirect()->back()->with('mesage', 'Số điện thoại đã tồn tại');
      }
      $user -> name = $request -> name;
      $user -> phone = $request -> phone;
      $user -> email = $request -> email;
      $user->save();
      return redirect()->back()->with('success', 'Cập thông tin thành công');
   }

   // cập nhật mật khẩu cho khách hàng
   function update_password_customer(Request $request, $id) {
      $user = users::find($id);
      if ($request->old_password !== $user->password) {
         return redirect()->back()->with('mesage', 'Mật khẩu không đúng');
      }
      $user->password = ($request->new_password);
      $user->save();
      return redirect()->back()->with('success', 'Cập nhật mật khẩu thành công');
   }

   // thanh toan vnpay
   function vnpay_payment($orderId){
      $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
      $vnp_Returnurl = "http://127.0.0.1:8000/paymentSuccess";
      $vnp_TmnCode = "AKXJR8ZD";//Mã website tại VNPAY 
      $vnp_HashSecret = "BVHPRYNBMOYBXZFQAJRSKSIDTDQYPWGQ"; //Chuỗi bí mật
      $vnp_TxnRef = $orderId; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
      $vnp_OrderInfo = 'thanh toan don hang';
      $vnp_OrderType = 'billpayment';
      $vnp_Amount = $_POST['tong'] * 100;
      // print_r($vnp_Amount);die;
      $vnp_Locale = 'vn';
      // $vnp_BankCode = 'NCB';
      $inputData = array(
         "vnp_BankCode" => isset($_POST['selectedBankInput']) ? $_POST['selectedBankInput'] : '',
      );
      $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
      $inputData = array(
         "vnp_Version" => "2.1.0",
         "vnp_TmnCode" => $vnp_TmnCode,
         "vnp_Amount" => $vnp_Amount,
         "vnp_Command" => "pay",
         "vnp_CreateDate" => date('YmdHis'),
         "vnp_CurrCode" => "VND",
         "vnp_IpAddr" => $vnp_IpAddr,
         "vnp_Locale" => $vnp_Locale,
         "vnp_OrderInfo" => $vnp_OrderInfo,
         "vnp_OrderType" => $vnp_OrderType,
         "vnp_ReturnUrl" => $vnp_Returnurl,
         "vnp_TxnRef" => $vnp_TxnRef
      );
      if (isset($vnp_BankCode) && $vnp_BankCode != "") {
         $inputData['vnp_BankCode'] = $vnp_BankCode;
      }
      ksort($inputData);
      $query = "";
      $i = 0;
      $hashdata = "";
      foreach ($inputData as $key => $value) {
         if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
         } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
         }
         $query .= urlencode($key) . "=" . urlencode($value) . '&';
      }
      $vnp_Url = $vnp_Url . "?" . $query;
      if (isset($vnp_HashSecret)) {
         $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
         $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
      }
      $returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);
      if (isset($_POST['redirect'])) {
         header('Location: ' . $vnp_Url);
         die();
      } else {
         echo json_encode($returnData);
      }
   }

   // lưu các thông tin vào dữ liệu
   function paymentSuccess(){
      if (isset($_GET['vnp_Amount'], $_GET['vnp_BankTranNo'])) {
         $orderId = $_GET['vnp_TxnRef'];
         $order = order_product::find($orderId);
         if ($order) {
            $order->payment_status = 2; // Đã thanh toán
            $order->save();
         }
         $vnpayTransaction = new \App\Models\tbl_vnpay();
         $userId = Session::get('home')['id'];
         $vnpayTransaction->fill([
            'order_id' => $_GET['vnp_TxnRef'],
            'user_id' => $userId,
            'vnp_Amount' => $_GET['vnp_Amount'],
            'vnp_BankCode' => $_GET['vnp_BankCode'],
            'vnp_BankTranNo' => $_GET['vnp_BankTranNo'],
            'vnp_CardType' => $_GET['vnp_CardType'],
            'vnp_OrderInfo' => $_GET['vnp_OrderInfo'],
            'vnp_PayDate' => $_GET['vnp_PayDate'],
            'vnp_TmnCode' => $_GET['vnp_TmnCode'],
            'vnp_TransactionNo' => $_GET['vnp_TransactionNo']
         ])->save();
         if ($userId) {
            $user = users::find($userId);
            if (!empty($user->email)) {
               Mail::send('backend.send_mail_pay', compact('order', 'user'), function($email) use ($user) {
                  $email->subject('Thanh toán thành công');
                  $email->to($user->email, $user->name);
               });
            }
        }
         return redirect()->route('home')->with('success', 'Thanh toán thành công');
      }
      else {
         return redirect()->route('home')->with('mesage', 'Thanh toán không thành công');
      }
   }


   // binh luan
   function send_comment(Request $request){
      $staff_id = $request->input('staff_id');
      $comment_content = $request->comment_content;
      $comment = new tbl_comment;
      $comment -> comment = $comment_content; 
      $comment -> staff_id = $staff_id; 
      $user_id = Session::get('home')['id'];
      $comment -> user_id = $user_id;
      $user = users::find($user_id);
      $user_name = $user->name;
      $comment -> comment_name = $user_name;
      $comment -> status_comment = 0;
      $comment -> comment_parent_comment = 0;
      $comment -> save();
   }

   function load_comment(Request $request){
      $staff_id = $request->input('staff_id');
      $user_id = Session::get('home')['id'];
      $comments = tbl_comment::where('staff_id', $staff_id)->where('comment_parent_comment', '=', 0)
      ->where('status_comment', 1)->get();
      $comment_rep = tbl_comment::where('comment_parent_comment', '>', 0)->orderByDesc('id')->get();
      $comment_id = tbl_comment::get()->toArray();
      $img_logo = asset('frontend/img/kisspng-light-fire-flame-logo-symbol-fire-letter-5ac5dab338f111.3018131215229160192332.jpg');
      $output = '';
      foreach($comments as $key => $comment){
         $user = users::find($comment->user_id);
         //  print_r($user);die;
         if ($user) {
            $avatar = asset('frontend/img/logo-login.png');
            if ($user->img) {
               $avatar = asset('uploads/users/' . $user->img);
            }
            $output .= '
               <div class="row mt-4 ps-3 ">
                  <div class="col-2 ">
                     <img class="img-customer-comment" src="'. $avatar .'" alt="img">
                  </div>
                  <div class="col-10 content-customer-comment pe-3">
                     <p class="text-success">@'. $comment->comment_name .'</p>
                     <p class="ms-3 text-warning mb-2">'. $comment->comment_date .'</p>
                     <p class="ms-3 lh-base mb-1 mt-1 ">'. $comment->comment .'</p>
                  </div>
               </div>
               ';
               if ($comment->user_id == $user_id) {
                  $output .= '
                     <div class="delete-comment-div">
                        <a href="'. route('delete-comment', ['id' => $comment->id]) .'" class="delete-comment-link" >Xóa</a>
                     </div>
                  ';
               }
         }
         foreach($comment_rep as $key => $rep_comment ){
            if($rep_comment->comment_parent_comment == $comment->id){
               $output .= '
               <div class="row mt-2 ms-5">
                  <div class="col-2">
                     <img class="logo-gastech-comment " src="'. $img_logo .'" alt="img">
                  </div>
                  <div class="col-10 content-customer-comment content-admin-comment pe-3">
                     <p class="comment-name-admin mb-2">@'. $rep_comment->comment_name .'</p>
                     <p class="ms-3 lh-base mb-2">'. $rep_comment->comment .'</p>
                  </div>
               </div>
               ';
            }
         }
      }
      echo $output;
   }

   // xóa comment
   function deleteComment($id) {
      $tbl_comment = tbl_comment::find($id);
      if ($tbl_comment) {
         $tbl_comment->delete();
      }
      return redirect()->back();
   }

   // nhắn tin khách hàng
   function send_message(Request $request){
      $message_content = $request->message_content;
      $message = new tbl_message;
      $message -> message_content = $message_content; 
      $user_id = Session::get('home')['id'];
      $message -> user_id = $user_id;
      $user = users::find($user_id);
      $user_name = $user->name;
      $message -> message_name = $user_name;
      $message -> message_parent_message = 0;
      $message -> save();
   }

   function load_message(Request $request){
      $user_id = Session::get('home')['id'];
      $message = tbl_message::where('user_id', $user_id)->where('message_parent_message', '=', 0)->get();
      $message_rep = tbl_message::where('message_parent_message', '>', 0)->orderByDesc('id')->get();
      $message_id = tbl_message::get()->toArray();
      $output = '';
      foreach($message as $key => $messages){
         $user = users::find($messages->user_id);
         if ($user) {
            $avatar = asset('frontend/img/logo-login.png');
            if ($user->img) {
               $avatar = asset('uploads/users/' . $user->img);
            }
            $output .= '
            <div class="message-reply-admin">
               <div class="message-orange">
                  <div class="message-content pb-4">'. $messages->message_content .'</div>
                  <p class="message-timestamp-right">'. $messages->created_at .'</p>
               </div>
            </div>
            ';
         }
         foreach($message_rep as $key => $rep_message ){
            if($rep_message->message_parent_message == $messages->id){
               $output .= '
               <div class="message-blue">
                  <div class="message-content">'. $rep_message->message_content .'</div>
                  <p class=" message-timestamp-left ">'. $rep_message->created_at .'</p>
               </div>
               ';
            }
         }
         
      }
      echo $output;
   }

}
