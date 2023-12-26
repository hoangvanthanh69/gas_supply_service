@extends('layouts.admin_gas')
@section('sidebar-active-product', 'active' )
@section('content')

      <div class="col-10 nav-row-10 ">   

        <div class="card mb-3 product-list element_column " data-item="product">
          <div class="card-header">
            <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-sp')}}">Sản phẩm</a></span>
          </div>
          <div class="card-body">
            <div class="table-responsive table-list-product">
              <div class="search-option-infor-amdin">
                <div class="search-infor-amdin-form-staff">
                  <a class="add-product" href="{{route('add-product-admin')}}">Thêm sản phẩm</a>
                </div>
                <div class="form-check-radio-product">
                  <form action="{{route('filters-product-type')}}" method="get"> 
                    <div id="loai" class="d-flex ">
                      <div class="form-check">
                        <input class="form-check-input form-check-input-type" type="radio" name="loai" value="1" id="type1" {{ ($filters['loai'] == '1') ? 'checked' : '' }} onclick="this.form.submit();">
                        <label class="form-check-label" for="type1">Gas công nghiệp</label>
                      </div>

                      <div class="form-check ms-5">
                        <input class="form-check-input form-check-input-type" type="radio" name="loai" value="2" id="type2" {{ ($filters['loai'] == '2') ? 'checked' : '' }} onclick="this.form.submit();">
                        <label class="form-check-label" for="type2">Gas dân dụng</label>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="import-excel-product">
                  <form action="{{route('import-excel-product')}}" id="submit_import_product" method="POST" enctype="multipart/form-data" class="d-flex">
                    @csrf
                    <input type="file" name="file" accept=".xlsx" class="choose-file-import-product">
                    <div class="submit-file-import-product">
                      <i class="fa-solid fa-file-import icon-file-import"></i>
                      <input type="submit" value="Nhập Excel" name="import_csv" >
                    </div>
                  </form>
                </div>

                <div class="export-file-excel export-file-excel-prodcut">
                  <a href="{{route('export-excel-product', ['loai' => $filters['loai'], 'search' => $search])}}" class="export-file-excel-button">
                    <i class="fa-solid fa-file-export"></i>Xuất Excel
                  </a>
                </div>

                <div class="search-infor-amdin-form-staff search-product-admin-form">
                  <form action="{{ route('admin.search_product') }}" method="GET" class="header-with-search-form ">
                    @csrf
                    <i class="search-icon-discount fas fa-search"></i>
                    <input type="text" autocapitalize="off" class="header-with-search-input header-with-search-input-discount" placeholder="ID, tên Sản Phẩm" name="search">
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
                    <th>Tên Sản Phẩm</th>
                    <th>Ảnh</th>
                    <th>Loại Gas</th>
                    <th>SL</th>
                    <th>Đơn Vị</th>
                    <th>Giá Bán</th>
                    <th>Ngày Tạo</th>
                    <th>Chức Năng</th>
                  </tr>
                </thead>
                
                <tbody class="infor">
                  @php
                    $typeFilter = $filters['loai'] ?? 'all';
                    $orderNumber = 0;
                  @endphp

                  @foreach($product as $key => $val)
                    @if($typeFilter == 'all' || $val['loai'] == $typeFilter)
                      @php
                        $orderNumber++;
                      @endphp
                      <tr class="hover-color">
                        <td class="name-product-td infor-product">{{$orderNumber}}</td>
                        <td class="name-product-td infor-product">ID: {{$val['id']}} - {{$val['name_product']}}</td>
                        <td class="img-product-td">
                          <img class="image-admin-product-edit"  src="{{asset('uploads/product/'.$val['image'])}}" width="100px"  alt="">
                        </td>
                        <td class="name-product-td infor-product">
                          <?php if($val['loai']==1){echo "<span style='color: #ef5f0e; font-weight: 500'>Gas công nghiệp</span>";}
                          else{echo "<span style='color: #09b6a6; font-weight: 500'>Gas dân dụng</span>";} ?>
                        </td>
                        <td class="name-product-td infor-product">{{$val['quantity']}}</td>
                        <td class="name-product-td infor-product">{{$val['unit']}}</td>
                        <td class="name-product-td infor-product">{{number_format($val['price'])}} đ</td>
                        <td class="name-product-td infor-product">{{$val['created_at']}}</td>
                        <td class="function-icon infor-product">
                          <form action="{{route('edit-product', $val['id'])}}">
                            <button class="summit-add-product-button" type='submit'>
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                          </form>
                          
                          <form action="{{route('delete-product', $val['id'])}}">
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
                    @endif
                  @endforeach 
                </tbody>
                <h1 id="showtext">
              </table>
              @if (!$search && (!$filters || $filters['loai'] == 'all'))
              <nav aria-label="Page navigation example" class="nav-link-page">
                <ul class="pagination">
                  @for ($i = 1; $i <= $product->lastPage(); $i++)
                    <li class="page-item{{ ($product->currentPage() == $i) ? ' active' : '' }}">
                      <a class="page-link a-link-page" href="{{ $product->url($i) }}">{{ $i }}</a>
                    </li>
                  @endfor
                </ul>
              </nav>
              @endif
            </div>
            
          </div>
        </div>
        <script>
          function toggleActiveButton() {
            const button = document.querySelector('.accordion-button');
            button.classList.toggle('active-button');
          }
          const links = document.querySelectorAll('.home-filter-buttons a');
          links.forEach(link => {
            link.addEventListener('click', toggleActiveButton);
          });
        </script>
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
        