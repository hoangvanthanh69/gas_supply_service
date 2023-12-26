@extends('layouts.admin_gas')
@section('sidebar-active-orders', 'active')
@section('content')

      <div class="col-10 nav-row-10 ">

        <div class="card mb-3 product-list element_column" data-item="receipt">
          <div class="card-header">
            <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-hd')}}">Đơn hàng</a></span>
          </div>

          <div class="d-flex justify-content-between pt-3">
            <div class="mt-2 ms-3">
              <form action="{{route('admin.search_hd')}}" method="GET" class="header-with-search-form ">
                @csrf
                <i class="search-icon-discount fas fa-search"></i>
                <input type="text" autocapitalize="off" class="header-with-search-input header-with-search-input-discount" placeholder="Mã ĐH, Tên KH, SĐT" name="search">
                <span class="header_search button" onclick="startRecognition()">
                  <i class="fas fa-microphone" id="microphone-icon"></i> 
                </span>
              </form>
              @if(Session::get('admin')['chuc_vu'] == "1")
                <div class="mt-2 bg-secondary">
                  <form action="{{route('search-invoices-deliverie')}}" method="GET" class="header-with-search-form ">
                    @csrf
                    <i class="search-icon-discount fas fa-search"></i>
                    <input type="text" autocapitalize="off" class="header-with-search-input header-with-search-input-discount " placeholder="Ô search cho nhân viên" name="search">
                  </form>
                </div>
              @endif
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
            </div>
            <!-- lọc đơn hàng theo ngày tháng năm -->
            <div class="mt-2">
              <form action="{{route('date-order-product')}}" class="form-filter-date-order" method="GET">
                <i class="fa-solid fa-calendar-days icon-filter-date-order"></i>
                <input class="date-filter-order" type="text" id="dateFilter" name="dateFilter" placeholder="dd-mm-yy • mm-yy • yy" value="{{$dateFilter}}"/>
              </form>
            </div>

            <form method="get" action="{{ route('filters-status-type') }}"> 
              <div>
                <select name="status" id="status" class="select-form-option select-form-option-status" onchange="this.form.submit()">
                  <option value="all" {{ ($filters['status'] == 'all') ? 'selected' : '' }}>Theo trạng thái</option>
                  <option value="1" {{ ($filters['status'] == '1') ? 'selected' : '' }}>Đang xử lý</option>
                  <option value="2" {{ ($filters['status'] == '2') ? 'selected' : '' }}>Đang giao</option>
                  <option value="3" {{ ($filters['status'] == '3') ? 'selected' : '' }}>Đã giao</option>
                  <option value="4" {{ ($filters['status'] == '4') ? 'selected' : '' }}>Đã hủy</option>
                </select>
              </div>
                <div id="loai" class="d-flex form-check-type-order">
                  <div class="form-check ms-5 mb-1">
                    <input class="form-check-input" type="radio" name="loai" value="1" id="type1" {{ ($filters['loai'] == '1') ? 'checked' : '' }} onclick="this.form.submit();">
                    <label class="form-check-label" for="type1">Gas công nghiệp</label>
                  </div>

                  <div class="form-check ms-4">
                    <input class="form-check-input" type="radio" name="loai" value="2" id="type2" {{ ($filters['loai'] == '2') ? 'checked' : '' }} onclick="this.form.submit();">
                    <label class="form-check-label" for="type2">Gas dân dụng</label>
                  </div>
                </div>
            </form>

            <!-- lọc đơn hàng từ a-z và z-a -->
            <div>
              <form method="GET" action="{{ route('sort_order') }}">
                <div class="div-filter-down mb-1">
                  <span>Tên khách hàng</span>
                  <span class="filter-data-created-at">
                    <i class="fa-solid fa-sort-down ms-1 fs-4 "></i>
                  </span>
                </div>

                <div class="filter-button-near-distant ms-5">
                  <button type="submit" class="sort-az" name="sort_order" value="asc">
                    <i class="fa-solid fa-arrow-down-a-z"></i>
                  </button>
                  <button type="submit" class="sort-za" name="sort_order" value="desc">
                    <i class="fa-solid fa-arrow-down-z-a"></i>
                  </button>
                </div>
              </form>
            </div>

            <!-- lọc đơn hàng theo ngày gần nhất và xa nhất -->
            <div>
              <form method="GET" action="{{ route('data_created_at') }}">
                <div class="div-filter-down me-4">
                  <span>Ngày tạo</span>
                  <span class="filter-data-created-at">
                    <i class="fa-solid fa-sort-down ms-1 fs-4 "></i>
                  </span>
                </div>
                <div class="filter-button-near-distant">
                  <button type="submit" class="sort-near" name="data_created_at" value="near">
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                  </button>
                  <button type="submit" class="sort-distant" name="data_created_at" value="distant">
                    <i class="fa-solid fa-arrow-down-short-wide"></i>
                  </button>
                </div>
              </form>
            </div>

            <!-- <div class="export-file-pdf">
              <a href=""> <i class="fa-solid fa-file-export"></i> Xuất PDF</a>
            </div> -->

          </div>
          
          <div class="card-body">
            <div class="table-responsive table-list-product">
              <div class="export-file-excel export-file-excel-order mb-2">
                <a href="{{ route('export-excel', ['status' => $filters['status'], 
                  'loai' => $filters['loai'], 'search' => $search, 'dateFilter' => $dateFilter]) }}" class="export-file-excel-button">
                  <i class="fa-solid fa-file-export me-1"></i>Xuất Excel
                </a>
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

              <table class="table table-bordered" id="dataTable" cellspacing="0" style="width: 100%">
                <thead>
                  <tr class="tr-name-table">
                    <th>STT</th>
                    <th >Mã ĐH</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th >Loại bình gas</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Người giao</th>
                    <th>Chức năng</th>
                  </tr>
                </thead>
                
                <tbody class="infor">
                  @php
                    $statusFilter = $filters['status'] ?? 'all';
                    $typeFilter = $filters['loai'] ?? 'all';
                  @endphp
                  
                  @foreach($order_product as $key => $val)
                    @if (($statusFilter == 'all' || $val['status'] == $statusFilter) && ($typeFilter == 'all' || $val['loai'] == $typeFilter))
                      <tr class="order-product-height hover-color">
                        <td class="order-product-infor-admin">{{$key+1}}</td>
                        <td class="order-product-infor-admin"> {{$val['order_code']}}</td>
                        <td class="order-product-infor-admin">{{$val['nameCustomer']}}</td>
                        <td class="order-product-infor-admin">{{$val['phoneCustomer']}}</td>
                        <td class="order-product-infor-admin"><?php if($val['loai']==1){echo 'Gas công nghiệp';}else{echo 'Gas dân dụng';}  ?></td>
                        <td class="order-product-infor-admin">
                          {{$val['created_at']}}
                        </td>
                        <td class="order-product-infor-admin">
                          <form method='POST' class="status-order-admin-form" action="{{route('status_admin', $val['id'])}}"> 
                            @csrf
                              <select class="select-option-update" onchange="this.form.submit()" name="status">
                                <option value="1" <?php echo  ($val['status'] == 1 ? 'selected' : ''); ?>> Đang xử lý</option>
                                <option value="2" <?php echo ($val['status'] == 2 ? 'selected' : ''); ?>> Đang giao</option>
                                <option value="3" <?php echo ($val['status'] == 3 ? 'selected' : ''); ?>> Đã giao</option>
                                <option value="4" <?php echo ($val['status'] == 4 ? 'selected' : ''); ?>> Đã hủy</option>
                              </select>
                          </form>
                        </td>
                        <td class="order-product-infor-admin"> <?php if($val['payment_status']==1){echo 'Khi nhận hàng';}else{echo 'Online VNPAY';}  ?></td>
                        <td class="order-product-infor-admin">
                          {{$val['admin_name']}}
                          @if($val['status'] != 3 && $val['admin_name'] != 'Chưa có người giao' && $val['admin_name'] != 'Người giao hủy')
                            <a href="{{route('cancel_delivery', $val['id'])}}" class='cancel-delivery'>
                              <i class="ps-2 fs-5 fa-solid fa-xmark"></i>
                            </a>
                            <h6 class="cancel-delivery-orders">Không nhận đơn giao</h6>
                          @endif
                        </td>
                        <td class="function-icon ">
                          <a class="browse-products" href="{{route('chitiet-hd', $val['id'])}}">
                            Xem chi tiết
                          </a>
                          <form action="{{route('delete-order', $val['id'])}}">
                            <button type="button" class="button-delete-order" data-bs-toggle="modal" data-bs-target="#exampleModal{{$val['id']}}">
                              <i class="fa fa-trash function-icon-delete" aria-hidden="true"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$val['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="exampleModalLabel">Bạn có chắc muốn xóa đơn hàng này</h5>
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
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
          document.querySelectorAll('.filter-data-created-at').forEach(function(span) {
            span.addEventListener('click', function() {
              var deleteCommentReply = this.parentElement.nextElementSibling;
              if (deleteCommentReply.style.display === 'none' || deleteCommentReply.style.display === '') {
                deleteCommentReply.style.display = 'block';
              } else {
                deleteCommentReply.style.display = 'none';
              }
            });
          });
        </script>
@endsection