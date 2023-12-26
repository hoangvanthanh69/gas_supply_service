@extends('layouts.admin_gas')
@section('sidebar-active-supplier', 'active' )
@section('content')

        <div class="col-10 nav-row-10 ">   
            <div class="mb-4 product-list-staff-add">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('nha-cung-cap')}}">Danh sách nhà cung cấp/</a>
                    <a class="text-decoration-none color-name-admin-add" href="{{route('add-supplier')}}">Thêm nhà cung cấp</a>
                </span>
            </div>
            <div class="add-staff-form">
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
                <div class="add-staff-heading-div">
                    <span>Tạo mới nhà cung cấp</span>
                </div>
                <form class="row container" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('add-suppliers')}}">
                    @csrf
                    <div class="col-4">
                        <span class="name-add-product-all" for="">Tên nhà cung cấp
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="name_supplier">
                    </div>

                    <div class="text-center mt-4">
                        <a class="back-product" href="{{route('nha-cung-cap')}}">Trở lại</a>
                        <button class="add-product button-add-product-save" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('frontend/js/jquery.validate.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
    	$("#signupForm").validate({
            rules: {
                name_supplier: {required: true, maxlength: 30},
            },
            messages: {
                name_supplier: {
                    required: "Nhập tên nhà cung cấp",
                    maxlength: "Nhập ngắn hơn"
                },
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