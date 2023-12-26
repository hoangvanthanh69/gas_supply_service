@extends('layouts.admin_gas')
@section('sidebar-active-supplier', 'active' )
@section('content')

    <div class="col-10 nav-row-10 ">   

        <div class="card mb-3 product-list element_column " data-item="product">
            <div class="card-header">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('nha-cung-cap')}}">Danh sách nhà cung cấp</a></span>
            </div>
            <div class="card-body">
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
                <div class="search-option-infor-amdin mt-2">
                    <div class="">
                        <a class="add-product" href="{{route('add-supplier')}}">Thêm nhà cung cấp</a>
                    </div>
                    <div class="me-3">
                        <form action="{{ route('search-suppliers') }}" method="GET" class="header-with-search-form">
                            @csrf
                            <i class="search-icon-discount fas fa-search"></i>
                            <input type="text" autocapitalize="off" class="header-with-search-input-discount" placeholder="Tìm kiếm" name="search">
                            <span class="header_search button" onclick="startRecognition()">
                                <i class="fas fa-microphone" id="microphone-icon"></i> 
                            </span>
                        </form>
                    </div>
                </div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="tr-name-table">
                            <th class="width-stt">STT</th>
                            <th>Nhà cung cấp</th>
                            <th>Ngày tạo</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody class="infor">
                        @foreach ($tbl_supplier as $key => $val)
                            <tr class="hover-color">
                                <td>{{$key+1}}</td>
                                <td>{{$val->name_supplier}}</td>
                                <td>{{$val['created_at']}}</td>
                                <td class="function-icon">
                                    <form action="{{route('edit-suppliers', $val['id'])}}">
                                        <button class="summit-add-product-button" type='submit'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </form>
                                    <form action="{{route('delete-supplier', $val['id'])}}">
                                        <button type="button" class="button-delete-order" data-bs-toggle="modal" data-bs-target="#exampleModal{{$val['id']}}">
                                        <i class="fa fa-trash function-icon-delete" aria-hidden="true"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{$val['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="exampleModalLabel">Bạn có chắc muốn xóa nhà cung cấp này</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                                                <button class="summit-add-room-button btn btn-primary" type='submit'>Xóa</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
        