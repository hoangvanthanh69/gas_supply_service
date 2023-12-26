@extends('layouts.admin_gas')
@section('sidebar-active-permissions', 'active' )
@section('content')

        <div class="col-10 nav-row-10 ">   
            <div class="mb-4 product-list-staff-add">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-phan-quyen')}}">Quản lý phân quyền /</a>
                <a class="text-decoration-none color-name-admin-add" href="{{route('add-permissions')}}">Thêm quyền</a>
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
                    <div class="search-infor-amdin-form-staff mt-3">
                        <a class="add-product" href="{{route('add-rights-group')}}">Thêm nhóm quyền</a>
                    </div>
                </div>
                <form class="row container" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('add-permission')}}">
                    @csrf
                    <div class="col-4">
                        <span class="name-add-product-all" for="">Nhóm quyền
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <select name="id_rights_group" class="form-select-delivery mt-2">
                            <option value="">--- Chọn ---</option>
                            @foreach($tbl_rights_group as $rights_group)
                                <option value="{{$rights_group->id}}">{{$rights_group->id}} - {{$rights_group->name_rights_group}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <span class="name-add-product-all" for="">Tên quyền
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="permission_name">
                    </div>

                    <div class="text-center mt-4">
                        <a class="back-product" href="{{route('add-role-permission')}}">Trở lại gán quyền</a>
                        <a class="back-product" href="{{route('danh-sach-quyen')}}">Trở lại ds quyền</a>
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
                permission_name: {required: true, maxlength: 30},
                id_rights_group: "required",      
            },
            messages: {
                permission_name: {
                    required: "Nhập tên quyền",
                    maxlength: "Nhập tên ngắn hơn"
                },
                id_rights_group: "Chọn nhóm quyền",
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