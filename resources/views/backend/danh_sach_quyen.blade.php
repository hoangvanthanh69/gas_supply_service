@extends('layouts.admin_gas')
@section('sidebar-active-permissions', 'active' )
@section('content')

    <div class="col-10 nav-row-10 ">   

        <div class="card mb-3 product-list element_column " data-item="product">
            <div class="card-header">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('danh-sach-quyen')}}">Danh sách quyền</a></span>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="search-infor-amdin-form-staff mt-3 mb-3">
                        <a class="add-product" href="{{route('add-permissions')}}">Thêm quyền</a>
                    </div>
                    <div class="mt-2 me-3">
                        <form action="{{route('search-permissions')}}" method="GET" class="header-with-search-form ">
                            @csrf
                            <i class="search-icon-discount fas fa-search"></i>
                            <input type="text" autocapitalize="off" class="header-with-search-input-discount" placeholder="Tên quyền" name="search">
                            <span class="header_search button" onclick="startRecognition()">
                            <i class="fas fa-microphone" id="microphone-icon"></i> 
                            </span>
                        </form>
                    </div>
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="tr-name-table">
                            <th class="width-stt">STT</th>
                            <th>Tên Quyền</th>
                            <th>Nhóm Quyền</th>
                            <th>Ngày tạo</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody class="infor">
                        @foreach ($tbl_permissions as $key => $val)
                            <tr class="hover-color">
                                <td>{{$key+1}}</td>
                                <td>{{$val->permission_name}}</td>
                                <td>{{$rights_group[$val['id_rights_group']]}}</td>
                                <td>{{$val->created_at}}</td>
                                <td class="function-icon">
                                    <form action="{{route('edit-permissions', $val['permission_id'])}}">
                                        <button class="summit-add-product-button" type='submit'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
        