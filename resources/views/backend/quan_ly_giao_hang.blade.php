@extends('layouts.admin_gas')
@section('sidebar-active-giao-hang', 'active' )
@section('content')

      <div class="col-10 nav-row-10 ">
        <div class="card mb-3 product-list element_column" data-item="receipt">
            <div class="card-header">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-giao-hang')}}">Giao hàng</a></span>
            </div>
            <form method="get">
                <div class="mt-3 ms-3 col-2">
                    <select name="district" id="district" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ !$selectedDistrict ? 'selected' : '' }}>Tất cả Quận/Huyện</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district }}" {{ $selectedDistrict == $district ? 'selected' : '' }}>{{ $district }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
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
                <div class="table-responsive table-list-product">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="tr-name-table-list">
                                <th>Mã ĐH</th>
                                <th>Tên Khách hàng</th>
                                <th>Địa chỉ</th>
                                <th>Thông tin sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Giao nhân viên</th>
                            </tr>
                        </thead>
                        
                        <tbody class="infor">
                            @foreach($order_product as $key => $val)
                                @if ($selectedDistrict == '' || $val['district'] == $selectedDistrict)
                                    <tr class="order-product-height hover-color">
                                        <td class="col-1">{{$val['order_code']}}</td>
                                        <td class="col-2">{{$val['nameCustomer']}}</td>
                                        <td class="col-3">{{$val['diachi']}}, {{$val['district']}},  {{$val['state']}}, {{$val['country']}}</td>
                                        <td class="col-3">
                                            @if (!empty($val['products']))
                                                @foreach ($val['products'] as $product)
                                                    <div class="d-flex">
                                                        <div class="col-3 infor-order-user-history">
                                                            <img class="image-admin-product-edit" src="{{asset('uploads/product/'.$product['product']->image)}}" width="70%" height="70%" alt="">       
                                                        </div>
                                                        <div class="col-7">{{ $product['product_name']}}</div>
                                                        <div class="col-2">Sl: {{ $product['quantity'] }}</div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="col-1">
                                            @if($val['status']==1)
                                                <span style="color: orange;">Đang xử lý</span>
                                            @elseif($val['status']==2)
                                                <span style="color: #52de20;">Đang giao</span>
                                            @endif
                                        </td>
                                        <td class="col-2">
                                            <form method="POST" action="{{route('quan_ly_giao_hangs')}}">
                                                @csrf
                                                {{$val['admin_name']}}
                                                <select name="admin_name" class="form-select-delivery"  onchange="this.form.submit()">
                                                    <option value="">--- Chọn ---</option>
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @foreach($tbl_admin as $admin)
                                                        @if($admin -> chuc_vu == 1)
                                                            @php
                                                                $count ++;
                                                            @endphp
                                                            <option value="{{$admin->admin_name}}">{{$count}} {{$admin-> admin_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="id" value="{{ $val['id'] }}">
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
             </div>
        </div>
@endsection
        