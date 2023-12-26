@extends('layouts.admin_gas')
@section('sidebar-active-home', 'active' )
@section('content')
<div class="col-10 nav-row-10 ">
    <div class="container-fluid">

    <div class="row">

        <h5 class="order-detail-overview">Thống kê chi tiết đơn hàng</h5>
        <!-- hóa đơn -->
        <div class="col-4 mb-4 total-product-initial">
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
            <div class="card statistical-all bg-warning">
                <div class="row no-gutters ">
                    <div class="col mr-2 p-3 text-light center-total-product">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-danger">
                            Tổng đơn hàng 
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span class="count-all">{{$count_order}}</span>
                            Đơn hàng
                        </div>
                    </div>
                    <div class="col-auto card-icon">
                        <i class="fas fa-calendar-check fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-4 mb-4">
                <div class="card statistical-all statistical-all-delivery">
                    <div class="row no-gutters" >
                        <div class="col mr-2 p-3 text-light center-total-product" >
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-danger">
                                Tổng đơn hàng đang giao
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="count-all">{{$count_order_delivery}}</span>
                                Đơn hàng
                            </div>
                        </div>
                        <div class="col-auto card-icon">
                            <i class="fa-solid fa-truck text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 mb-4">
                <div class="card statistical-all statistical-all-processing">
                    <div class="row no-gutters ">
                        <div class="col mr-2 p-3 text-light center-total-product">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-dark">
                                Tổng đơn hàng đang xử lý
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="count-all">{{$count_order_processing}}</span>
                                    Đơn hàng
                            </div>
                            
                        </div>
                        <div class="col-auto card-icon">
                            <i class="fa fa-spinner text-secondary fs-3" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 mb-4">
                <div class="card statistical-all statistical-all-canceled">
                    <div class="row no-gutters ">
                        <div class="col mr-2 p-3 text-light center-total-product">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-info">
                                Tổng đơn hàng đã hủy
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="count-all">{{$count_order_canceled}}</span>
                                    Đơn hàng
                            </div>
                            
                        </div>
                        <div class="col-auto card-icon">
                            <i class="fa-solid fa-ban text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 mb-4">
                <div class="card statistical-all statistical-all-delivered">
                    <div class="row no-gutters ">
                        <div class="col mr-2 p-3 text-light center-total-product">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-warning">
                                Tổng đơn hàng giao thành công
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <span class="count-all">{{$count_order_delivered}}</span>
                                    Đơn hàng
                            </div>
                            
                        </div>
                        <div class="col-auto card-icon">
                            <i class="fa-solid fa-check text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="text-primary text-decoration-none" href="{{route('admin')}}"><i class="fa-solid fa-angles-left"></i> Quay lại</a>

    </div>
@endsection

</div>