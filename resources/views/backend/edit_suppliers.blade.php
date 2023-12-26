@extends('layouts.admin_gas')
@section('sidebar-active-supplier', 'active' )
@section('content')

        <div class="col-10 nav-row-10 ">   
            <div class="mb-4 product-list-staff-add">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="">Cập nhật nhà cung cấp</a>
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
                    <span>Cập nhật nhà cung cấp</span>
                </div>
                <form class="row container" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('update-suppliers', $tbl_supplier->id)}}">
                    @csrf
                    <div class="col-4">
                        <span class="name-add-product-all" for="">Tên nhà cung cấp
                            <span class="color-required fw-bolder">*</span>
                        </span>
                        <input class="input-add-product col-11 mt-2 ps-2" type="text" name="name_supplier" value="{{$tbl_supplier->name_supplier}}">
                    </div>

                    <div class="text-center mt-4">
                        <a class="back-product" href="{{route('nha-cung-cap')}}">Trở lại</a>
                        <button class="add-product button-add-product-save" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
@endsection