@extends('layouts.admin_gas')
@section('sidebar-active-customer', 'active' )
@section('content')

      <div class="col-10 nav-row-10 ">

        <div class="card mb-3 product-list element_column" data-item="staff">
          <div class="card-header">
            <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-nv')}}">Quản lý nhân viên</a></span>
          </div>
          <div class="search-option-infor-amdin">
            <div class="add-product-div-admin add-staff-admin">
              <a class="add-staffs" href="{{route('add-staff')}}">Thêm Nhân viên</a>
            </div>

            <div class="export-file-excel-staff">
              <form action="{{route('export-excel-staff')}}" method="POST">
                @csrf
                <button type="submit" value="" name="export_csv" class="export-file-excel-button">
                  <i class="fa-solid fa-file-export"></i>Xuất Excel
                </button>
              </form>
            </div>

            <div class="search-infor-amdin-form">
                <form action="{{ route('admin.search_staff') }}" method="GET" class="header-with-search-form ">
                  @csrf
                  <i class="search-icon-discount fas fa-search"></i>
                  <input type="text" autocapitalize="off" class="header-with-search-input header-with-search-input-discount" placeholder="Mã Số, Họ Tên" name="search">
                  <span class="header_search button" onclick="startRecognition()">
                    <i class="fas fa-microphone" id="microphone-icon"></i> 
                  </span>
                </form>
            </div>
          </div>
          
          <div class="card-body">
            <div class="table-responsive table-list-product">
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
                    <th >Mã số </th>
                    <th class="align-center">Ảnh</th>
                    <th class="col-1 align-center">Họ Tên</th>
                    <th class="align-center">SĐT</th>
                    <th class="">Năm sinh</th>
                    <th class="align-center">CCCD</th>
                    <th>Giới tính</th>
                    <th class="">Chức vụ</th>
                    <th class="col-1 align-center">Tài khoản @</th>
                    <th class="col-2 align-center">Địa chỉ</th>
                    <th class="col-1">Ngày vào làm</th>
                    <th class="col-1 align-center">Lương/Tháng</th>
                    <th >Chức năng</th>
                  </tr>
                </thead>
                
                <tbody class="infor">
                  @foreach($staff as $key => $val)
                    <tr class="hover-color">
                      <td class="product-order-quantity">{{$val['id']}}</td>
                      
                        <td class="img-product-td">
                          <img class="image-admin-product-edit"  src="{{asset('uploads/staff/'.$val['image_staff'])}}" width="100px"  alt="">
                        </td>

                        <td class="name-product-td">{{$val['last_name']}}</td>

                        <td class="product-order-quantity">{{$val['phone']}}</td>

                        <td class="product-order-quantity">{{$val['birth']}}</td>

                        <td class="product-order-quantity">{{$val['CCCD']}}</td>

                        <td class="product-order-quantity"><?php if($val['gioi_tinh']==1){echo "Nam";} else{echo "Nữ";}  ?></td>

                        <td class="roduct-order-quantity">
                          <?php
                            if($val['chuc_vu']==1){echo "<span style='color: #2679A0; font-weight: 500'>Giao hàng</span>";} 
                            elseif($val['chuc_vu']==3){echo "<span style='color: #77d020; font-weight: 500'>Biên tập</span>";} 
                            else{echo "<span style='color: red; font-weight: 500'>Quản lý</span>";} 
                          ?>
                        </td>

                        <td class="product-order-quantity">{{$val['taikhoan']}}</td>

                        <td class="product-order-quantity">{{$val['dia_chi']}}</td>

                        <td class="product-order-quantity">{{$val['date_input']}}</td>

                        <td class="product-order-quantity">{{number_format($val['luong'])}} <span class="text-decoration-underline">đ</span></td>

                        <td class="function-icon function-icon-staff">
                          <form action="{{route('edit-staff', $val['id'])}}">
                            <button class="summit-add-product-button" type='submit'>
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                          </form>
                          
                          <form action="{{route('delete-staff', $val['id'])}}">
                            <button type="button" class="button-delete-order" data-bs-toggle="modal" data-bs-target="#exampleModal{{$val['id']}}">
                              <i class="fa fa-trash function-icon-delete" aria-hidden="true"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$val['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="exampleModalLabel">Bạn có chắc muốn xóa nhân viên này</h5>
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
              <nav aria-label="Page navigation example" class="nav-link-page">
                <ul class="pagination">
                  @for ($i = 1; $i <= $staff->lastPage(); $i++)
                    <li class="page-item{{ ($staff->currentPage() == $i) ? ' active' : '' }}">
                      <a class="page-link a-link-page" href="{{ $staff->url($i) }}">{{ $i }}</a>
                    </li>
                  @endfor
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
@endsection
