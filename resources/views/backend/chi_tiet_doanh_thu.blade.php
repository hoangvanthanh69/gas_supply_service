@extends('layouts.admin_gas')
@section('sidebar-active-home', 'active' )
@section('content')

<div class="col-10 nav-row-10 ">
    <div class="">
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
        <div class="card ms-4">
            <div class="card-header">
                <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('chi_tiet_doanh_thu')}}">Thống kê chi tiết doanh thu</a></span>
            </div>
            <div class="row ps-4 pe-4 pt-3 pb-3 ">
                <a class="text-primary text-decoration-none mb-3" href="{{route('admin')}}"><i class="fa-solid fa-angles-left"></i> Quay lại</a>
                <!-- tổng doanh thu  -->
                <div class="col-4">
                    <div class="card statistical-alls statistical-all-delivered">
                        <div class="row no-gutters ">
                            <div class="col mr-2 p-3 text-light center-total-product">
                                <div class="text-xs font-weight-bold text-uppercase mb-2 text-warning">
                                    Tổng doanh thu ngày hôm nay
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <span class="count-all">{{$dates}}: {{number_format ($total_price_today)}} đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card statistical-alls statistical-delivered-date">
                        <div class="row no-gutters ">
                            <div class="col mr-2 p-3 text-light center-total-product">
                                <div class="text-xs font-weight-bold text-uppercase mb-2 text-warning">
                                    Tổng doanh thu từng ngày
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <form action="{{ route('chi_tiet_doanh_thu') }}" method="GET">
                                        <label for="date">Chọn ngày:</label>
                                        <input class="input-total-revenue" type="date" id="date" name="date" value="{{ $date }}" />
                                        <button class="button-total-revenue" type="submit">Tìm</button>
                                    </form>
                                    <span class="count-all">{{$date}}: {{number_format($tong_gia_ngay)}} đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card statistical-alls statistical-delivered-month">
                        <div class="row no-gutters ">
                            <div class="col mr-2 p-3 text-light center-total-product">
                                <div class="text-xs font-weight-bold text-uppercase mb-2 text-warning">
                                    Tổng doanh thu theo tháng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <form action="{{ route('chi_tiet_doanh_thu') }}" method="GET">
                                        <label for="month">Chọn tháng:</label>
                                        <input class="input-total-revenue" type="month" id="month" name="month" value="{{$month}}" />
                                        <button class="button-total-revenue" type="submit">Tìm</button>
                                    </form>
                                    <span class="count-all">{{ $month }}: {{ number_format($total_price_month) }} đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card statistical-alls statistical-delivered-year">
                        <div class="row no-gutters ">
                            <div class="col mr-2 p-3 text-light center-total-product">
                                <div class="text-xs font-weight-bold text-uppercase mb-2 text-warning">
                                    Tổng doanh thu theo năm
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <form action="{{ route('chi_tiet_doanh_thu') }}" method="GET">
                                        <label for="date">Chọn năm:</label>
                                        <input class="input-total-revenue" type="year" id="year" name="year" value="{{ $year }}" />
                                        <button class="button-total-revenue" type="submit">Tìm</button>
                                    </form>
                                    <span class="count-all">{{$year}}: {{number_format ($total_price_year)}} đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-4">
                    <div class="card statistical-alls statistical-delivered-period">
                        <div class="row no-gutters ">
                            <div class="col mr-2 p-3 text-light center-total-product">
                                <div class="text-xs font-weight-bold text-uppercase mb-2 text-warning">
                                    Tổng doanh thu theo khoảng
                                </div>
                                <div class="h5 mb-2 font-weight-bold text-gray-800">
                                    <form method="GET" action="{{ route('chi_tiet_doanh_thu') }}" class="">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="start_date" class="date-start">Ngày bắt đầu:</label>
                                            <input class="input-total-revenue" type="date" id="start_date" name="start_date" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="end_date">Ngày kết thúc:</label>
                                            <input class="input-total-revenue" type="date" id="end_date" name="end_date" required />
                                            <button class="button-total-revenue" type="submit">Tính</button>
                                        </div>
                                    </form>
                                    <span class="count-all">{{$start_date}} đến {{$end_date}} là: {{number_format($total_revenue)}} đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

</div>