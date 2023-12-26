@extends('layouts.admin_gas')
@section('sidebar-active-product-inventory', 'active' )
@section('content')

    <div class="col-10 nav-row-10 ">   
        <div class="card mb-3 product-list element_column " data-item="product">
          <div class="card-header">
            <span class="product-list-name"><a class="text-decoration-none color-name-admin" href="{{route('admin')}}">Admin</a> / <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-ton-kho')}}">Danh sách tồn kho</a></span>
          </div>
          <div class="card-body">
            <div class="table-responsive table-list-product">
                <div class="search-option-infor-amdin">
                  <div class="mb-1 search-infor-amdin-form-staff">
                    <form action="{{route('filters-inventory-type')}}" method="get"> 
                      <div id="loai" class="d-flex mt-1">
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

                  <div class="export-file-excel export-excel-inventory">
                    <a href="{{route('export-excel-inventory', ['loai' => $filters['loai'], 'search' => $search])}}" class="export-file-excel-button">
                      <i class="fa-solid fa-file-export"></i>Xuất Excel
                    </a>
                  </div>

                  <div class="mb-1 search-infor-amdin-form-staff">
                    <form action="{{route('search-inventory')}}" method="GET" class="header-with-search-form ">
                      @csrf
                        <i class="search-icon-discount fas fa-search"></i>
                        <input type="text" autocapitalize="off" class="header-with-search-input header-with-search-input-discount" placeholder="Mã, ID_tên SP" name="search">
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
                    <th>STT</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Loại SP</th>
                    <th>SL Trong Kho</th>
                    <th>Tổng SL Nhập</th>
                    <th>Tổng Giá Nhập</th>
                    <th>SL Đã Bán</th>
                  </tr>
                </thead>
                
                <tbody class="infor">
                  @php
                    $typeFilter = $filters['loai'] ?? 'all';
                  @endphp
                  @foreach($product as $key => $products)
                    @if($typeFilter == 'all' || $products['loai'] == $typeFilter)
                    <tr>
                      <td class="">{{$key+1}}</td>
                      <td>ID: {{$products->id}} - {{$products->name_product}}</td>
                      <td> 
                        <?php if($products->loai ==1){echo "<span style='color: #ef5f0e; font-weight: 500'>Gas công nghiệp</span>";}
                          else{echo "<span style='color: #09b6a6; font-weight: 500'>Gas dân dụng</span>";} ?>
                      </td>
                      <!-- số lượng trong kho -->
                      <td class="">{{$products->quantity}}</td>
                      <!-- <td>{{number_format($products->price)}} đ</td> -->
                      <!-- Tổng số lượng nhập -->
                      <td>{{$totalQuantity[$products->id] ?? 0}}</td>
                      <!-- Tổng giá nhập -->
                      <td>{{number_format($totalPrice[$products->id] ?? 0)}} đ</td>
                      <!-- số lượng đã bán -->
                      <td>{{$quantity_sold[$products->id] ?? 0}}</td>
                    </tr>
                    @endif
                  @endforeach
                </tbody>
                <h1 id="showtext">
              </table>
              @if(!$search && (!$filters || $filters['loai'] == 'all'))
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
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
        