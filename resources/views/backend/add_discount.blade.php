@extends('layouts.admin_gas')
@section('sidebar-active-discount', 'active' )
@section('content')

        <div class="col-10 nav-row-10 ">
            <div class="mb-4 product-list-staff-add">
                <span class="product-list-name fs-5">
                    <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-giam-gia')}}">Danh sách mã giảm</a> / <a class="text-decoration-none" href="{{route('add-discount')}}">Thêm mã mới</a>
                </span>
            </div>
            <div class="add-staff-form">
                <div class="add-staff-heading-div">
                    <span>Tạo mã</span>
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
                <form class="row container" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('add-discounts')}}">
                    @csrf
                    
                    <div class="col-4">
                        <span class="name-add-product-all" for="">Tên mã
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="name_voucher">
                    </div>

                    <div class="col-4">
                        <span class="name-add-product-all" for="">Mã giảm
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product ps-2 col-11 mt-2 ps-2 pe-2" type="text" name="ma_giam">
                    </div>

                    <div class="col-4">
                        <span class="name-add-product-all " for="">Số lượng
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="number" name="so_luong">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">Điều kiện (VNĐ)
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="Prerequisites">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">Loại giảm
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <select id="type" name="type" class="input-add-product col-11 ps-2 pe-2 mt-2" aria-label="Default select example">
                            <option value="">Chọn Loại</option>
                            <option value="1">Giảm theo phần trăm (%)</option>
                            <option value="2">Giảm theo giá tiền (VNĐ)</option>
                        </select>   
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">Giá trị giảm
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="gia_tri">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">Giảm từ ngày
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2 pe-2" type="datetime-local" name="thoi_gian_giam">
                    </div>

                    <div class="col-4 mt-4">
                        <span class="name-add-product-all " for="">Ngày hết hạn giảm
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2 pe-2" type="datetime-local" name="het_han">
                    </div>

                    <div class="text-center mt-4">
                        <a class="back-product" href="{{route('quan-ly-giam-gia')}}">Trở lại</a>
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
					name_voucher: {required: true, maxlength: 30},
					ma_giam: {required: true, maxlength: 30},
					so_luong: {
                        required: true,
                        number: true ,
                        max: 100,
                        min: 1
                    },
                    gia_tri: {
                        required: true,
                        number: true ,
                        min: 1
                    },
                    thoi_gian_giam: "required",                        
                    het_han: "required",       
                    type: "required",       
                    Prerequisites: {
                        required: true,
                        number: true,
                        maxlength: 15,
                        min: 1
                    }
				},
				messages: {
					name_voucher: {
						required: "Nhập tên",
						maxlength: "Nhập tên ngắn hơn"
					},
					ma_giam: {
						required: "Nhập mã giảm",
						maxlength: "Nhập mã giảm ngắn hơn"
					},
					so_luong: {
                        required: "Nhập số lượng",
                        number: "Vui lòng chỉ nhập số nguyên",
                        max: "Vui lòng nhập số lượng nhỏ hơn 100",
                        min:"Vui lòng nhập số lượng lớn hơn 0"
                    },
                    gia_tri: {
                        required: "Nhập giá trị giảm",
                        number: "Vui lòng chỉ nhập số",
                        min:"Vui lòng nhập giá trị lớn hơn 0"
                    },
					thoi_gian_giam: "Nhập ngày bắt đầu giảm",
					het_han: "Nhập ngày hết hạn giảm",
					type: "Chọn loại giảm giá",
                    Prerequisites:{
                        required: "Nhập (giá trị) điều kiện giảm",
                        number: "Vui lòng chỉ nhập số",
                        maxlength:"Vui lòng nhập không quá 30 kí tự",
                        min:"Vui lòng nhập điều kiện lớn hơn 0"
                    }
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