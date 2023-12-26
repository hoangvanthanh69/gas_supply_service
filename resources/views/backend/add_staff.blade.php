@extends('layouts.admin_gas')
@section('sidebar-active-customer', 'active' )
@section('content')

        <div class="col-10 nav-row-10 ">
            <div class="mb-4 product-list-staff-add">
                <span class="product-list-name fs-5">
                    <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-nv')}}">Danh sách nhân viên</a> / <a class="text-decoration-none color-name-admin-add" href="{{route('add-staff')}}">Thêm nhân viên mới</a>
                </span>
            </div>
            <div class="add-staff-form">
                <div class="add-staff-heading-div">
                    <span>Tạo mới nhân viên</span>
                </div>
                @if (session('success'))
                    <div class="change-password-customer-home d-flex">
                    <i class="far fa-check-circle icon-check-success"></i>
                    {{ session('success') }}
                    </div>
                @endif
                @if (session('message'))
                    <div class="success-customer-home-notification d-flex">
                    <i class="fas fa-ban icon-check-cancel"></i>
                    {{ session('message') }}
                    </div>
                @endif
                <form class="row container" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('staff_add')}}">
                    @csrf
                    <div class="col-4">
                        <span class="name-add-product-all col-4 " for="">Thêm ảnh
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product name-add-product-all-img col-11 mt-2" type="file" name="image_staff">
                    </div>

                    <div class="col-4">
                        <span class="name-add-product-all" for="">Họ và Tên
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="last_name">
                    </div>

                    <div class="col-4">
                        <span class="name-add-product-all" for="">Năm sinh
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product ps-2 col-11 mt-2 ps-2 pe-2" type="date" name="birth">
                    </div>

                    <div class="col-4 mt-4 ">
                        <span class="name-add-product-all" for="">Chức vụ
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <div class='mt-2 p-0'>
                            <select id="chuc_vu" name="chuc_vu" class="input-add-product col-11 ps-2 pe-2" aria-label="Default select example">
                                <option value="">Chọn chức vụ</option>
                                <option value="1" name="cv_nv">Giao hàng</option>
                                <option value="2">Quản lý</option>
                                <option value="3">Biên tập</option>
                            </select>    
                        </div>
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all" for="">Tài khoản @
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="taikhoan">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all" for="">Địa chỉ thường trú
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="dia_chi">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">CCCD
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="CCCD">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">Giới tính
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <select id="gioi_tinh" name="gioi_tinh" class="input-add-product col-11 mt-2 ps-2 pe-2" aria-label="Default select example">
                            <option value="">Chọn giới tính</option>
                            <option value="1" >Nam</option>
                            <option value="2">Nữ</option>
                        </select> 
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">Ngày vào làm
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2 pe-2" type="date" name="date_input">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all" for="">Số điện thoại
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="phone">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all" for="">Lương/tháng
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="luong">
                    </div>

                    <div class="text-center mt-4">
                        <a class="back-product" href="{{route('quan-ly-nv')}}">Trở lại</a>
                        <button class="add-product button-add-product-save" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('frontend/js/jquery.validate.js')}}"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate({
				rules: {
					last_name: {required: true, maxlength: 30},
					birth: "required",
					cv_nv: "required",
                    taikhoan: {required: true, email: true, maxlength: 30},
                    dia_chi: {required: true, maxlength: 100},
                    date_input: "required",                        
                    phone: {required: true, maxlength: 11, minlength: 10, number: true},                   
                    luong: {
                        required: true,
                        number: true,
                    }, 
                    CCCD: {
                        required: true,
                        number: true,
                        maxlength: 30
                    },           
                    chuc_vu: "required",
                    image_staff : "required",
                    gioi_tinh: "required"
				},
				messages: {
					last_name: {
						required: "Nhập họ tên",
						maxlength: "Nhập họ tên ngắn hơn"
					},
					birth: "Nhập ngày sinh",
					cv_nv: "Chọn chức vụ",
					taikhoan: {
                        required: "Nhập tài khoản",
                        email: "Tài khoản không đúng định dạng",
                        maxlength: "Tên tài khoản không quá 30 kí tư"
                    },
					dia_chi: {
                        required: "Nhập địa chỉ",
                        maxlength: "Địa chỉ không quá 100 kí tự",
                    },
					date_input: "Nhập ngày vào làm",
					phone: {
						required: "Nhập số điện thoại",
						maxlength: "Không đúng định dạng",
                        minlength: "Không đúng định dạng",
                        number: "Vui lòng nhập số",
					},
					luong: {
                        required: "Nhập lương /tháng",
                        number: "Vui lòng nhập số",
                    },
                    CCCD: {
                        required: "Nhập CCCD",
                        number: "Vui lòng nhập số",
                        maxlength: "CCCD không quá 30 kí tự"
                    },
                    chuc_vu: "Chọn chức vụ",
                    image_staff: "Chọn ảnh",
                    gioi_tinh: "Chọn giới tính"

				},
				errorElement: "div",
				errorPlacement: function (error, element) {
					error.addClass("invalid-feedback-staff");
					if (element.prop("type") === "checkbox"){
						error.insertAfter(element.siblings("label"));
					} else {
						error.insertAfter(element);
					}
				},
				highlight: function (element, errorClass, validClass) {
					$(element).addClass("is-invalid").removeClass("is-valid");
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).addClass("is-valid").removeClass("is-invalid");
				} 

			});
        });
</script>

        </div>

    </div>
</div>
