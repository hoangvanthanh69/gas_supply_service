@extends('layouts.admin_gas')
@section('sidebar-active-shipper', 'active' )
@section('content')
<div class="col-10 nav-row-10 ">
<div class="card mb-3 product-list element_column" data-item="staff">
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
   <div class="card-header">
      <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('nhan-vien-giao-hang')}}">Nhân viên giao hàng</a></span>
   </div>       
   <div class="card-body">
      <div class="table-responsive table-list-product">
         <!-- lọc đơn hàng theo ngày tháng năm -->
         <div class="">
            <form action="{{route('data-filter-shiper')}}" class="form-filter-date-order d-flex" method="GET">
               <div class="">
                  <label for="" class="ps-2">Thời gian:</label>
                  <div>
                     <i class="fa-solid fa-calendar-days icon-filter-date-delivery-staff"></i>
                     <input class="date-filter-order pb-1" type="text" id="date_Filter" name="date_Filter" placeholder="dd-mm-yy • mm-yy • yy" value="{{$date_Filter}}"/>
                  </div>
               </div>
               <div class="d-flex">
                  <div class=" padding-left-warehouse">
                     <label for="" class="ps-2">Từ ngày:</label>
                        <div>
                          <input class="date-filter-order ps-3 pb-1" type="text" id="date_Filter_start" name="date_Filter_start" placeholder="• dd-mm-yy" value="{{$date_Filter_start}}"/>
                        </div>
                  </div>

                  <div class="padding-left-warehouse">
                     <label for="" class="ps-2">Đến ngày:</label>
                     <div>
                        <input class="date-filter-order ps-3 pb-1" type="text" id="date_Filter_end" name="date_Filter_end" placeholder="• dd-mm-yy" value="{{$date_Filter_end}}"/>
                     </div>
                  </div>
               </div>
               <button type="submit" class="d-none"></button>
            </form>
         </div>
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
               <tr class="tr-name-table">
                  <th class="width-stt">STT</th>
                  <th>Ảnh</th>
                  <th>Họ Tên</th>
                  <th>Chức Vụ</th>
                  <th>Số Đơn</th>
                  <th>Tổng tiền giao</th>
               </tr>
            </thead>
            <tbody class="infor">
               @foreach($tbl_admin as $key => $val)
               <tr class="hover-color">
                  <td>{{$key+1}}</td>
                  <td class="img-product-td">
                     <img class="image-admin-product-edit"  src="{{asset('uploads/staff/'.$val['image_staff'])}}" width="100px"  alt="">
                  </td>
                  <td class="product-order-quantity">{{$val['admin_name']}}</td>
                  <td class="product-order-quantity"><?php 
                     if($val['chuc_vu']==1){echo "<span style='color: #2679A0; font-weight: 500'>Giao hàng</span>";} 
                     elseif($val['chuc_vu']==3){echo "<span style='color: #77d020; font-weight: 500'>Biên tập</span>";} 
                     else{echo "<span style='color: red; font-weight: 500'>Quản lý</span>";}  ?>
                  </td>
                  <td class="product-order-quantity">{{$val['order_count']}}</td>
                  <td>{{number_format($val['total_sales'])}} đ</td>
               </tr>
               @endforeach 
            </tbody>
         </table>
      </div>
   </div>
</div>

@endsection
