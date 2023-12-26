@extends('layouts.admin_gas')
@section('sidebar-active-product-warehouse', 'active' )
@section('content')

      <div class="col-10 nav-row-10 ">   

        <div class="card mb-3 product-list element_column " data-item="product">
          <div class="card-header">
            <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-kho')}}">Danh sách nhập kho</a></span>
          </div>
          <div class="card-body">
            <div class="table-responsive table-list-product">
              <div class="d-flex mt-5 ">
                <div class="add-warehouse-product">
                  <a class="add-product" href="{{route('add-product-warehouse')}}">Nhập kho sản phẩm</a>
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
                <!-- lọc đơn hàng theo ngày tháng năm -->
                <div class="search-product-admin-form">
                  <form action="{{ route('filters-date-warehouse') }}" class="form-filter-date-order d-flex" method="GET">
                    <div class="d-block date-period-warehouse">
                      <label for="" class="ps-2">Thời gian:</label>
                      <div>
                        <i class="fa-solid fa-calendar-days icon-filter-date-order"></i>
                        <input class="date-filter-order pb-1" type="text" id="date_Filter_warehouse" name="date_Filter_warehouse" placeholder="dd-mm-yy • mm-yy • yy" value="{{$date_Filter_warehouse}}"/>
                      </div>
                    </div>
                    <div class="date-period-warehouse d-flex">
                      <div class=" padding-left-warehouse">
                        <label for="" class="ps-2">Từ ngày:</label>
                        <div>
                          <input class="date-filter-order ps-3 pb-1" type="text" id="date_Filter_warehouse_start" name="date_Filter_warehouse_start" placeholder="• dd-mm-yy" value="{{$date_Filter_warehouse_start}}"/>
                        </div>
                      </div>

                      <div class="padding-left-warehouse">
                        <label for="" class="ps-2">Đến ngày:</label>
                        <div>
                          <input class="date-filter-order ps-3 pb-1" type="text" id="date_Filter_warehouse_end" name="date_Filter_warehouse_end" placeholder="• dd-mm-yy" value="{{$date_Filter_warehouse_end}}"/>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="d-none"></button>
                  </form>
                </div>

                <div class="search-product-admin-form padding-left-warehouse">
                  <form action="{{route('search-warehouse')}}" method="GET" class="header-with-search-form ">
                    @csrf
                    <i class="search-icon-discount fas fa-search"></i>
                    <input type="text" autocapitalize="off" class="header-with-search-input header-with-search-input-discount" placeholder="Mã, ID_tên SP, tên NV" name="search">
                    <span class="header_search button" onclick="startRecognition()">
                      <i class="fas fa-microphone" id="microphone-icon"></i> 
                    </span>
                  </form>
                </div>
              </div>

              <div class="d-flex mt-4 pt-3">
                <div class="import-excel-product">
                  <form action="{{route('import-excel-warehouse')}}" id="submit_import_product" method="POST" enctype="multipart/form-data" class="d-flex">
                    @csrf
                    <input type="file" name="file" accept=".xlsx" class="choose-file-import-product">
                    <div class="submit-file-import-product">
                      <i class="fa-solid fa-file-import icon-file-import"></i>
                      <input type="submit" value="Nhập Excel" name="import_csv" >
                    </div>
                  </form>
                </div>

                <div class="export-file-excel export-file-excel-warehouse">
                  <a href="{{route('export-excel-warehouse', ['search' => $search, 'date_Filter_warehouse' => $date_Filter_warehouse, 
                    'date_Filter_warehouse_start' => $date_Filter_warehouse_start, 'date_Filter_warehouse_end' => $date_Filter_warehouse_end,
                    ])}}" class="export-file-excel-button">
                    <i class="fa-solid fa-file-export"></i>Xuất Excel
                  </a>
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
                    <th>Mã Nhập</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Nhà cung cấp</th>
                    <th>SL</th>
                    <th>Đơn vị</th>
                    <th>Giá Nhập</th>
                    <th>Tổng</th>
                    <th>Nhân Viên Nhập</th>
                    <th>Ngày Nhập</th>
                    <th>Chức Năng</th>
                  </tr>
                </thead>
                
                <tbody class="infor">
                  @foreach ($product_warehouse as $key => $val)
                    <tr class="">
                        <td class="">{{ $key + 1 }}</td>
                        <td class="">{{ $val['batch_code'] }}</td>
                        <td class="">ID: {{ $val['product_id'] }} - {{ $productNames[$val['product_id']] }}</td>
                        <td>
                          @if (isset($supplierNames[$val['supplier_id']]))
                            {{ $supplierNames[$val['supplier_id']] }}
                          @else
                            {{ 'Giá trị không tồn tại' }}
                          @endif
                        </td>
                        <td class="">{{ $val['quantity'] }}</td>
                        <td>{{$productUnit[$val['product_id']]}}</td>
                        <td>{{ number_format($val['price']) }} đ</td>
                        <td>{{ number_format($val['total']) }} đ</td>
                        <td class="">
                          @if (isset($admin_Names[$val['staff_id']]))
                            {{ $admin_Names[$val['staff_id']] }}
                          @else
                            {{ 'Giá trị không tồn tại' }}
                          @endif
                        </td>

                        <td class="">{{$val['created_at']}}</td>
                        <td class=" ">
                          <!-- <form action="">
                            <button class="summit-add-product-button" type='submit'>
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                          </form> -->
                          
                          <form action="{{route('delete-warehouse', $val['id'])}}">
                            <button type="button" class="button-delete-order" data-bs-toggle="modal" data-bs-target="#exampleModal{{$val['id']}}">
                              <i class="fa fa-trash function-icon-delete" aria-hidden="true"></i>
                            </button>
                              <!-- Modal -->
                              <div class="modal fade" id="exampleModal{{$val['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title text-danger" id="exampleModalLabel">Bạn có chắc muốn xóa sản phẩm này</h5>
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
                <h1 id="showtext">
              </table>
              @if (!$search && (!$date_Filter_warehouse) && (!$date_Filter_warehouse_start))
                <nav aria-label="Page navigation example" class="nav-link-page">
                  <ul class="pagination">
                    @for ($i = 1; $i <= $product_warehouse->lastPage(); $i++)
                      <li class="page-item{{ ($product_warehouse->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link a-link-page" href="{{ $product_warehouse->url($i) }}">{{ $i }}</a>
                      </li>
                    @endfor
                  </ul>
                </nav>
              @endif
            </div>
          </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{asset('frontend/js/jquery.validate.js')}}"></script>
        <script type="text/javascript">
          $(document).ready(function(){
            $("#submit_import_product").validate({
              rules: {
                file: "required",
              },
              messages: {
                file: "Chọn file cần import",
              },
              errorElement: "div",
              errorPlacement: function (error, element) {
                error.addClass("invalid-feedback-import");
                if (element.prop("type") === "checkbox"){
                  error.insertAfter(element.siblings("label"));
                } else {
                  error.insertAfter(element);
                }
              },
              highlight: function (element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
              },
              unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
              } 
            });
          });
        </script>
@endsection
        