<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\index;
use App\Http\Controllers\index_backend;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// trang home customer
Route::get('/home', [index::class, 'home'] )->name('home');

// login
Route::get('/login', [AuthController::class, 'login'] )->name('login');

// đăng nhập admin
Route::post('getlogin', [AuthController::class, 'getlogin'] )->name('getlogin');
Route::get('logout', [AuthController::class, 'logout'] )->name('logout');

// order sản phẩm
Route::post('/order-product', [index::class, 'order_product'] )->name('order-product');

Route::post('/order', [index::class, 'order'] )->name('order');
Route::post('/get-product-by-id', [index::class, 'getProductByID'] )->name('get-product-by-id');

// Route::post('/handle-order', [index::class, 'handle_order'] )->name('handle-order');

Route::get('/admin', [index_backend::class, 'home'] )->name('admin')->middleware('check.permission:23');

//đăng nhập user
Route::get('/dangnhap', [AuthController::class, 'showLoginForm'] )->name('dangnhap');
Route::post('/dangnhap', [AuthController::class, 'dangnhap'] )->name('dangnhap');

//đăng kí user
Route::get('/register', [AuthController::class, 'register'] )->name('register');
Route::post('/registers', [AuthController::class, 'registers'] )->name('registers');

//đăng xuât người dùng
Route::get('logoutuser', [AuthController::class, 'logoutuser'] )->name('logoutuser');

// lịch sử đơn hàng
Route::get('/order-history', [index::class, 'order_history'] )->name('order-history');

// hủy đơn hàng cập nhật lại trạng thái cho khách hàng
Route::get('/cancel_order/{id}', [index::class, 'cancelOrder'])->name('cancel_order');

// lộc hóa đơn
Route::get('/loc-hd', [index_backend::class, 'loc_hd'] )->name('loc-hd');

// phân quyền nhân viên
Route::get('/don_hang_nhan_vien', [index_backend::class, 'hien_thi_don_hang_nhan_vien'])->name('don_hang_nhan_vien');

// thông tin đơn hàng của khách hàng
Route::get('/thong_tin_don_hang/{id}', [index::class, 'thong_tin_don_hang'])->name('thong_tin_don_hang');

// thống kế chi tiết tổng đơn hàng
Route::get('/admin/thong_ke_chi_tiet_dh', [index_backend::class, 'thong_ke_chi_tiet_dh'])->name('thong_ke_chi_tiet_dh');

// chi tiet doanh thu
Route::get('/admin/chi_tiet_doanh_thu',[index_backend::class,'chi_tiet_doanh_thu'])->name('chi_tiet_doanh_thu');

// cap nhat ảnh cho khach hang
Route::post('update_image_user/{id}', [index::class, 'update_image_user'])->name('update_image_user');

// cập nhật mật khẩu cho khách hàng
Route::post('/update-password-customer/{id}', [index::class, 'update_password_customer'])->name('update-password-customer');


// thanh toán vnpay

    Route::post('/vnpay_payment', [index::class, 'vnpay_payment'])->name('vnpay_payment');
    Route::get('/paymentSuccess', [index::class, 'paymentSuccess'] )->name('paymentSuccess');
    Route::post('/load-comment', [index::class,'load_comment'])->name('load-comment');
    Route::post('/send-comment', [index::class,'send_comment'])->name('send-comment');

// 

// đăng nhập bằng google

    Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('login-by-google');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// 

// Sản phẩm
    //  quản lý sản phẩm
    Route::get('/admin/quan-ly-kho-sp', [ProductController::class, 'quan_ly_sp'] )->name('quan-ly-sp')->middleware('check.permission:31');

    // giao diện thêm sản phẩm
    Route::get('/add-product-admin', [ProductController::class, 'add_product'] )->name('add-product-admin')->middleware('check.permission:15');

    // xử lý thêm sản phẩm
    Route::post('/add-product', [ProductController::class, 'add_products'] )->name('add-product');

    // giao diện chỉnh sửa sản phẩm
    Route::get('/edit-product/{id}', [ProductController::class, 'edit_product'])->name('edit-product')->middleware('check.permission:2');

    // xử lý cập nhật sản phẩm
    Route::post('/update-product/{id}', [ProductController::class, 'update_product'] )->name('update-product');

    // xóa sản phẩm
    Route::get('/delete/{id}/product', [ProductController::class, 'delete_product'] )->name('delete-product')->middleware('check.permission:3');

    // tìm kiếm sản phẩm
    Route::get('/admin/quan-ly-kho-sp/search_product', [ProductController::class, 'search_product'])->name('admin.search_product');

    // lọc sản phẩm theo loại
    Route::get('admin/quan-ly-kho-sp/filters-product-type', [ProductController::class, 'filters_product_type'])->name('filters-product-type');

    // export excel cho ds kho sản phẩm
    Route::get('export-excel-product', [ProductController::class, 'export_excel_product'])->name('export-excel-product');

    // import file excel cho sản phẩm
    Route::post('import-excel-product', [ProductController::class, 'import_excel_product'])->name('import-excel-product');

    // quản lý nhập kho
    Route::get('admin/quan-ly-nhap-kho', [ProductController::class, 'quan_ly_kho'])->name('quan-ly-kho')->middleware('check.permission:2');

    // giao diện nhập kho sản phẩm
    Route::get('/add-product-warehouse', [ProductController::class, 'add_product_warehouse'])->name('add-product-warehouse')->middleware('check.permission:4');

    // xử lý nhập kho sản phẩm
    Route::post('/add-warehouse', [ProductController::class, 'add_warehouse'])->name('add-warehouse');

    // xóa nhập kho sản phẩm
    Route::get('/delete-warehouse/{id}', [ProductController::class, 'delete_warehouse'])->name('delete-warehouse')->middleware('check.permission:6');

    // tìm kiếm nhập kho
    Route::get('admin/quan-ly-nhap-kho/search-warehouse', [ProductController::class, 'search_warehouse'])->name('search-warehouse');

    // lọc nhập kho theo ngày mua hàng
    Route::get('admin/quan-ly-nhap-kho/filters-date-warehouse',[ProductController::class, 'filters_date_warehouse'])->name('filters-date-warehouse');

    // xuất excel cho nhập kho
    Route::get('export-excel-warehouse', [ProductController::class, 'export_excel_warehouse'])->name('export-excel-warehouse');

    // import file excel cho nhập kho sản phẩm
    Route::post('import-excel-warehouse', [ProductController::class, 'import_excel_warehouse'])->name('import-excel-warehouse');
    
    // quản lý tồn kho
    Route::get('admin/quan-ly-ton-kho', [ProductController::class, 'quan_ly_ton_kho'])->name('quan-ly-ton-kho')->middleware('check.permission:7');

    // tìm kiếm tồn kho
    Route::get('search-inventory', [ProductController::class, 'search_inventory'])->name('search-inventory');

    // lọc theo loại tồn kho
    Route::get('admin/quan-ly-ton-kho/filters-inventory-type', [ProductController::class, 'filters_inventory_type'])->name('filters-inventory-type');

    // xuất excel cho tồn kho
    Route::get('export-excel-inventory', [ProductController::class, 'export_excel_inventory'])->name('export-excel-inventory');

    // giao diện nhà cung cấp gas
    Route::get('nha-cung-cap', [ProductController::class, 'nha_cung_cap_gas'])->name('nha-cung-cap')->middleware('check.permission:32');

    // giao diện thêm nhà cung cấp gas
    Route::get('add-supplier', [ProductController::class, 'add_supplier'])->name('add-supplier');

    // xử lý thêm nhà cung cấp gas
    Route::post('add-suppliers', [ProductController::class, 'add_suppliers'])->name('add-suppliers');

    // giao diện chỉnh sửa nhà cung cấp gas
    Route::get('edit-suppliers/{id}', [ProductController::class, 'edit_suppliers'])->name('edit-suppliers');
    
    // xử lý nhà cung cấp
    Route::post('update-suppliers/{id}', [ProductController::class, 'update_suppliers'])->name('update-suppliers');

    // tìm kiếm nhà cung cấp
    Route::get('nha-cung-cap/search-suppliers', [ProductController::class, 'searchsuppliers'])->name('search-suppliers');

    // xóa nhà cung cấp
    Route::get('delete-supplier/{id}', [ProductController::class, 'delete_supplier'])->name('delete-supplier');
    

// 

// Đơn hàng
    // quản lý hóa đơn
    Route::get('/admin/quan-ly-hd', [OrderController::class, 'quan_ly_hd'] )->name('quan-ly-hd')->middleware('check.permission:8');

    // xóa đơn hàng
    Route::get('/delete-order/{id}', [OrderController::class, 'delete_order'] )->name('delete-order')->middleware('check.permission:9');

    // tìm kiếm hóa đơn
    Route::get('/admin/quan-ly-hd/search_hd', [OrderController::class, 'search_hd'])->name('admin.search_hd')->middleware('check.permission:26');

    //lọc đơn hàng theo tên a-z, z-a
    Route::get('admin/quan-ly-hd/sort_order', [OrderController::class, 'sort_order'])->name('sort_order')->middleware('check.permission:29');

    //lọc đơn hàng theo ngày gần nhất và xa nhất
    Route::get('quan-ly-hd/data_created_at', [OrderController::class, 'data_created_at'])->name('data_created_at')->middleware('check.permission:30');

    // lọc ngày mùa hàng
    Route::get('admin/quan-ly-hd/date-order-product', [OrderController::class, 'date_order_product'])->name('date-order-product')->middleware('check.permission:27');

    // lọc đơn hàng theo loại và trạng thái
    Route::get('admin/quan-ly-hd/filters-status-type', [OrderController::class, 'filters_status_type'])->name('filters-status-type')->middleware('check.permission:28');

    // export_excel cho ds đơn hàng
    Route::get('export-excel', [OrderController::class, 'export_excel'])->name('export-excel')->middleware('check.permission:25');

    // in đơn hàng chi tiết đơn hàng pdf
    Route:: get('/print-order/{checkout_code}', [OrderController::class, 'print_order'] )->name('print-order');

    // chi tiết đơn hàng
    Route::get('/chitiet-hd/{id}', [OrderController::class, 'chitiet_hd'] )->name('chitiet-hd');
    Route::get('/chitiet/{id}', [index_backend::class, 'chitiet'] )->name('chitiet');

    // giao diện đặt hàng cho khách hàng điện thoại
    Route::get('/order_phone', [index_backend::class, 'order_phone'])->name('order_phone')->middleware('check.permission:10');

    // xử lý đặt hàng cho khách hàng qua số điện thoại
    Route::post('add-order', [index_backend::class, 'add_orders'])->name('add-order');

    // tìm kiếm sản phẩm đặt qua đt
    Route::get('/admin/search_order_phone', [index_backend::class, 'search_order_phone'])->name('admin.search_order_phone');

    // giao diện quản lý đơn hàng giao
    Route::get('/admin/quan-ly-giao-hang', [index_backend::class, 'quan_ly_giao_hang'])->name('quan-ly-giao-hang');

    // xử lý đơn hàng giao
    Route::post('/quan_ly_giao_hangs', [index_backend::class, 'quan_ly_giao_hangs'])->name('quan_ly_giao_hangs');

    // kiểm tra khách hàng thông qua số điện thoại
    Route::post('check-customer', [index_backend::class, 'checkCustomer'])->name('check-customer');

    // hủy giao hành cho nhân viên
    Route::get('/cancel-delivery/{id}', [OrderController::class, 'cancelDelivery'])->name('cancel_delivery');

    // tìm kiếm hóa đơn cho nhân viên giao hàng
    Route::get('search-invoices-deliverie', [OrderController::class, 'search_invoices_deliverie'])->name('search-invoices-deliverie');

// 

// Nhân viên

    // quản lý nhân viên
    Route:: get('/admin/quan-ly-nv', [StaffController::class, 'quan_ly_nv'] )->name('quan-ly-nv');

    // giao diện thêm nhân viên
    Route::get('/add-staff', [StaffController::class, 'add_staff'] )->name('add-staff')->middleware('check.permission:11');

    // xử lý thêm nhân viên
    Route::post('/staff_add', [StaffController::class, 'staff_add'] )->name('staff_add');

    // xóa nhân viên
    Route::get('/delete-staff/{id}/staff-add', [StaffController::class, 'delete_staff'] )->name('delete-staff')->middleware('check.permission:13');

    // giao diện edit nhân viên
    Route::get('/edit-staff/{id}', [StaffController::class, 'edit_staff'] )->name('edit-staff')->middleware('check.permission:12');

    // xử lý cập nhật nhân viên
    Route::post('/update-staff/{id}', [StaffController::class, 'update_staff'] )->name('update-staff');

    // tìm kiếm nhân viên
    Route::get('/admin/search-staff', [StaffController::class, 'searchStaff'])->name('admin.search_staff');

    // export excel cho ds nhân viên
    Route::post('export-excel-staff', [StaffController::class, 'export_excel_staff'])->name('export-excel-staff');

    // giao diện nhân viên giao hàng (đếm số đơn giao)
    Route::get('/admin/nhan-vien-giao-hang', [StaffController::class, 'nhan_vien_giao_hang'])->name('nhan-vien-giao-hang');

    // lọc số đơn hàng cho từng ngày tháng năm giao hàng
    Route::get('/data-filter-shiper', [StaffController::class, 'data_filter_shiper'] )->name('data-filter-shiper');  

// 

// Đánh giá giao hàng

    // đánh giá giao hàng
    Route::get('/admin/danh-gia-giao-hang', [index_backend::class, 'danh_gia_giao_hang'])->name('danh-gia-giao-hang');
    Route::post('/admin/danh_gia_giao_hangs/{id?}', [index::class, 'danh_gia_giao_hangs'])->name('danh_gia_giao_hangs');

// 

// Tài khoản quản trị
    // tài khoản admin
    Route::get('/admin/quan-ly-tk-admin', [index_backend::class, 'quan_ly_tk_admin'] )->name('quan-ly-tk-admin')->middleware('check.permission:24');

    //cập nhật trạng thái cho admin
    Route::post('/status_admin/{id}', [OrderController::class, 'status_admin'])->name('status_admin');

    // thêm tài khoản admin
    Route::get('/admin/add_account_admin', [index_backend::class, 'add_account_admin'] )->name('add_account_admin');

    // Xử lý thêm tài khoản quản trị
    Route::post('/add_account/{id}', [index_backend::class, 'add_account'] )->name('add_account');

    // giao diện chỉnh sửa tài khoản admin
    Route::get('edit-account-admin/{id}', [index_backend::class, 'edit_account_admin'])->name('edit-account-admin');

    // xử lý cập nhật tải khoản quản trị
    Route::post('update-account-admin/{id}', [index_backend::class, 'update_account_admin'])->name('update-account-admin');

    // xóa tải khoản quản trị
    Route::get('/delete_account/{admin_id}/tbl_admin', [index_backend::class, 'delete_account'] )->name('delete_account');  

// 

// Tài khoản khách hàng

    // quản lý tài khoản khách hàng
    Route::get('admin/quan-ly-tk-user', [index_backend::class, 'quan_ly_tk_user'] )->name('quan-ly-tk-user');

    // xóa tài khoản khách hàng
    Route::get('/delete_account_users/{id}/users', [index_backend::class, 'delete_account_users'] )->name('delete_account_users');

// 

// Mã giảm giá

    // quản lý giảm giá
    Route::get('/admin/quan-ly-giam-gia', [DiscountController::class, 'quan_ly_giam_gia'])->name('quan-ly-giam-gia');

    // giao diện thêm mã giảm giá 
    Route::get('/add-discount', [DiscountController::class, 'add_discount'])->name('add-discount');

    // thêm mã mới
    Route::post('add-discounts', [DiscountController::class, 'add_discounts'])->name('add-discounts');

    // giao diện edit mã giảm giá
    Route::get('/edit-discount/{id}', [DiscountController::class, 'edit_discount'])->name('edit-discount');

    // xử lý cập nhật mã giảm giá
    Route::post('/update-discounts/{id}',[DiscountController::class, 'update_discounts'])->name('update-discounts');

    // tìm kiếm mã giảm
    Route::get('/admin/searchDiscount', [DiscountController::class, 'searchDiscount'])->name('admin.searchDiscount');

    // cập nhật trạng thái mã giảm giá
    Route::post('/update_status_discount', [DiscountController::class, 'update_status_discount'])->name('update_status_discount');

    // xóa mã giảm giá
    Route::get('/delete_discount/{id}', [DiscountController::class, 'delete_discount'])->name('delete_discount');

    // kiểm tra mã giảm giá
    Route::post('check-coupon', [DiscountController::class, 'check_coupon'])->name('check-coupon');

    // cập nhật số lượng
    Route::post('update-discount-quantity', [index::class, 'update_discount_quantity'])->name('update-discount-quantity');
    Route::post('update-discount-quantitys', [index_backend::class, 'update_discount_quantitys'])->name('update-discount-quantitys');
    Route::post('notification-discount-quantity', [DiscountController::class, 'notification_discount_quantity'])->name('notification-discount-quantity');

// 

// Bình luận 

    // quản lý bình luận
    Route::get('admin/quan-ly-binh-luan', [index_backend::class, 'quan_ly_binh_luan'])->name('quan-ly-binh-luan');

    // xóa bình luận
    Route::get('/delete-comment/{id}', [index::class, 'deleteComment'])->name('delete-comment');

    // ẩn và hiển thị bình luận
    Route::get('/hide-comments/{id}', [index_backend::class, 'hide_comments'])->name('hide-comments');
    Route::get('/unhide-comments/{id}', [index_backend::class, 'unhide_comments'])->name('unhide-comments');

    // trả lời bình luận
    Route::post('/reply-comment', [index_backend::class, 'reply_comment'])->name('reply-comment');

    // xóa bình luận bên admin
    Route::get('/delete_comment_admin/{id}/tbl_comment', [index_backend::class, 'delete_comment_admin'] )->name('delete_comment_admin');

    // xóa trả lời bình luận
    Route::get('/delete_reply_comment/{id}/tbl_comment', [index_backend::class, 'delete_reply_comment'] )->name('delete_reply_comment');

    // tìm kiếm bình luận
    Route::get('/search-comment', [index_backend::class, 'search_comment'])->name('search-comment');
    
// 

// Tin nhắn
    // Gửi và load tin nhắn bên khách hàng
    Route::post('/send-message', [index::class,'send_message'])->name('send-message');
    Route::post('/load-message', [index::class,'load_message'])->name('load-message');

    // quản lý tin nhắn
    Route::get('admin/quan-ly-tin-nhan', [index_backend::class, 'quan_ly_tin_nhan'])->name('quan-ly-tin-nhan');

    // trả lời tin nhắn
    Route::post('/reply-message', [index_backend::class, 'reply_message'])->name('reply-message');

    // xóa tin nhắn
    Route::get('/delete-message/{user_id}/tbl_message', [index_backend::class, 'delete_message'] )->name('delete-message');
// 

// Phân quyền

    // quản lý phân quyền
    Route::get('admin/quan-ly-phan-quyen',[PermissionsController::class, 'quan_ly_phan_quyen'])->name('quan-ly-phan-quyen');

    // giao thêm quyền và xử lý thêm quyền 
    Route::get('add-permissions', [PermissionsController::class, 'add_permissions'])->name('add-permissions')->middleware('check.permission:21');
    Route::post('add-permission', [PermissionsController::class, 'add_permission'])->name('add-permission');

    // cập nhật gán quyền cho nhân viên
    Route::post('/update-role-permissions/{id}', [PermissionsController::class, 'updateRolePermissions'])->name('update-role-permissions');

    // giao diện gán quyền cho nhân viên 
    Route::get('admin/add-role-permission', [PermissionsController::class, 'add_role_permission'])->name('add-role-permission')->middleware('check.permission:16');

    // gán quyền cho quản trị viên
    Route::post('role-permissions', [PermissionsController::class, 'role_permissions'])->name('role-permissions');

    // hiển thị giao diện chỉnh sửa gán quyền
    Route::get('edit-role-permissions/{id_admin}', [PermissionsController::class, 'edit_role_permissions'])->name('edit-role-permissions')->middleware('check.permission:17');

    //Xóa gán quyền ở quản trị viên
    Route::get('delete-role-permissions/{id_admin}', [PermissionsController::class, 'delete_role_permissions'])->name('delete-role-permissions')->middleware('check.permission:18');

    // hiển thị thêm nhóm quyền
    Route::get('/add-rights-group', [PermissionsController::class, 'add_rights_group'])->name('add-rights-group');

    // xử lý thêm nhóm quyền
    Route::post('/add-rights-groups', [PermissionsController::class, 'add_rights_groups'])->name('add-rights-groups');

    // dánh sách quyền
    Route::get('admin/danh-sach-quyen', [PermissionsController::class, 'danh_sach_quyen'])->name('danh-sach-quyen')->middleware('check.permission:19');

    // danh sách nhóm quyền
    Route::get('admin/danh-sach-nhom-quyen', [PermissionsController::class, 'danh_sach_nhom_quyen'])->name('danh-sach-nhom-quyen')->middleware('check.permission:22');

    // giao diện chỉnh sửa và xử lý quyền
    Route::get('/edit-permissions/{permission_id}', [PermissionsController::class, 'edit_permissions'])->name('edit-permissions')->middleware('check.permission:20');
    Route::post('/update-permissions/{permission_id}', [PermissionsController::class, 'update_permissions'])->name('update-permissions');

    // xóa quyền
    Route::get('/delete-permissions/{permission_id}', [PermissionsController::class, 'delete_permissions'])->name('delete-permissions');

    // giao diện chỉnh sửa nhóm quyền
    Route::get('/edit-tbl-rights-group/{id}', [PermissionsController::class, 'edit_tbl_rights_group'])->name('edit-tbl-rights-group');
    
    // xư lý chỉnh sửa nhóm quyền
    Route::post('/update-tbl-rights-group/{id}', [PermissionsController::class, 'update_tbl_rights_group'])->name('update-tbl-rights-group');

    // tìm kiếm quyền
    Route::get('/search-permissions', [PermissionsController::class, 'search_permissions'])->name('search-permissions');

    // tìm kiếm gán quyền
    Route::get('/search-role-permissions', [PermissionsController::class, 'search_role_permissions'])->name('search-role-permissions');
    

// 

// biểu đồ
    // biểu đồ doanh thu
    Route::get('/revenue-chart', [index_backend::class, 'revenueChart'])->name('revenue-chart');
    
    // Lấy doanh thu cho tháng hiện tại
    Route::get('/revenue-for-current-month', [index_backend::class, 'getCurrentMonthRevenue'])->name('revenue-for-current-month');

    // biểu đồ tròn đơn hàng giao thành công và đã hủy
    Route::get('/status-chart', [index_backend::class, 'statusChart'])->name('status-chart');

    // biểu đồ cột doanh thu theo ngày
    Route::get('/get-revenue-data', [index_backend::class, 'getRevenueData'])->name('get-revenue-data');

// 
