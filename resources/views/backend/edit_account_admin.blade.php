@extends('layouts.admin_gas')
@section('sidebar-active-tai-khoan', 'active' )
@section('content')
        <div class="col-10 nav-row-10 ">
            <div class="add-product-each w-50 ">
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
                <form enctype="multipart/form-data" method='post' action="{{route('update-account-admin', $account_admin->id)}}">
                    <h5 class="text-center ms-5 mb-5 text-success">Thay đổi mật khẩu cho tài khoản quản trị</h5>
                    @csrf
                    <div class="row">
                        <label class="name-add-product-all col-4" for="">Họ và Tên:</label>
                        <input class="input-add-product col-8" type="text" name="admin_name" value="{{$account_admin->admin_name}}">
                    </div>

                    <div class="row mt-4">
                        <label class="name-add-product-all col-4" for="">Tài khoản @:</label>
                        <input class="input-add-product col-8" type="text" name="admin_email" value="{{$account_admin->admin_email}}">
                    </div>

                    <div class="row mt-4">
                        <label class="name-add-product-all col-4" for="">Mật khẩu:</label>
                        <input class="input-add-product col-8" type="text" name="admin_password" value="{{$account_admin->admin_password}}">
                    </div>

                    <div class="back-add-product">
                        <a class="back-product" href="{{route('quan-ly-tk-admin')}}">Trở lại</a>
                        <button class="add-product button-add-product-save" type="submit">Cập nhật lại mật khẩu</button>
                    </div>
                </form>
            </div>
@endsection

        </div>

      
    </div>
</div>