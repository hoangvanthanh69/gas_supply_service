@extends('layouts.admin_gas')
@section('sidebar-active-tai-khoan', 'active' )
@section('content')
<div class="col-10 nav-row-10 ">
<div class="card mb-3 product-list element_column" data-item="staff">
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
               <h5 class="list-account-admin">Dang sách tài khoản nhân viên</h5>
               <tr class="tr-name-table-list">
                  <th>STT</th>
                  <th>Ảnh</th>
                  <th class="">Name</th>
                  <th class="">Email</th>
                  <th>Chức vụ</th>
                  <th>Password</th>
                  <th>Chức năng</th>
               </tr>
            </thead>
            
            <tbody class="infor">
               @foreach($staff as $key => $val)
                  <tr class="hover-color">
                     <td>{{$key+1}}</td>
                     <td>
                        <img class="image-admin-product-edit" src="{{asset('uploads/staff/'.$val['image_staff'])}}" width="100px"  alt="">
                     </td>
                     <td class="name-product-td">{{$val['last_name']}}</td>
                     <td class="product-order-quantity">{{$val['taikhoan']}}</td>
                     <td><?php 
                        if($val['chuc_vu']==1){echo "<span style='color: #2679A0; font-weight: 500'>Giao hàng</span>";} 
                        elseif($val['chuc_vu']==3){echo "<span style='color: #1bd64b; font-weight: 500'>Biên tập</span>";} 
                        else{echo "<span style='color: #e7055c; font-weight: 500'>Quản lý</span>";}  ?>
                     </td>
                     <form id="signupForm" action="{{route('add_account', $val['id'])}}" method="POST">
                        @csrf
                        <td>
                           @if($val['status_add'])
                           
                           @else
                              <input class="input-password-admin" type="text" name="password" placeholder="Nhập mật khẩu" required autofocus>
                           @endif
                        </td>
                        <td>
                           @if($val['status_add'])
                              <span class="text-success">Đã thêm</span>
                           @else
                              <button class="add-account-admin-approved" type='submit'>
                                 Lưu tài khoản
                              </button>
                           @endif
                        </td>
                     </form>
                  </tr>
               @endforeach
            </tbody>
         </table>
         <a class="text-primary" href="quan-ly-tk-admin">
            <i class="fa-solid fa-arrow-left"></i>
            Quay lại
         </a>
      </div>
   </div>
</div>

@endsection
