@extends('layouts.admin_gas')
@section('sidebar-active-product', 'active' )
@section('content')

      <div class="col-10 nav-row-10 ">
        <div class="mb-4 product-list-staff-add">
          <span class="product-list-name fs-5">
            <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-sp')}}">Danh sách sản phẩm</a> / <a class="text-decoration-none color-name-admin-add" href="">Cập nhật thông tin sản phẩm</a>
          </span>
          </div>
        <div class="add-staff-form">
          <div class="add-staff-heading-div">
            <span>Cập nhật sản phẩm</span>
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
            <form class="row container" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('update-product',$product->id)}}">
              @csrf
                <div class="col-4">
                  <span class="name-add-product-all" for="">Tên sản phẩm:</span>
                  <input class="input-add-product col-11 mt-2 ps-2" type="text" name="name_product" value="{{ $product->name_product }}">
                </div>

                <div class="col-4">
                  <span class="name-add-product-all" for="loai">Loại bình gas:</span>
                  <div class='mt-2 p-0'>
                    <select id="loai" name="loai"  class="input-add-product col-11 ps-2 pe-2" aria-label="Default select example">
                      <option value="">Chọn loại gas</option>
                      <option value="1" <?php echo  $product['loai']==1?'selected':'' ?>>Gas công nghiệp</option>
                      <option value="2" <?php echo  $product['loai']==2?'selected':'' ?>>Gas dân dụng</option>
                    </select>    
                  </div>
                </div>

                <div class="col-4">
                  <span class="name-add-product-all" for="">Đơn vị:</span>
                  <input class="input-add-product col-11 mt-2 ps-2" type="text" name="unit" value="{{ $product->unit}}">
                </div>

                <div class="col-4 mt-3">
                  <span class="name-add-product-all col-4" for="">Thêm ảnh:</span>
                  <div class="">
                    <input class="input-add-product name-add-product-all-img col-8 mt-2" type="file" name="image" >
                    <img class="col-4 ms-3 image-admin-product-edit" src="{{asset('uploads/product/'.$product['image']) }}" alt="" style="width: 130px">
                  </div>
                </div>

                <div class="col-4 mt-3">
                  <span class="name-add-product-all" for="">Giá bán:</span>
                  <input class="input-add-product col-11 mt-2 ps-2" type="text" name="price" value="{{ $product->price}}">
                </div>
                
                <div class="text-center mt-4">
                    <a class="back-product" href="{{route('quan-ly-sp')}}">Trở lại</a>
                  <button class="add-product button-add-product-save" name="update-category-product" type="submit">Cập nhật sản phẩm</button>
                </div>
            </form>
        </div>
@endsection

      </div>

    </div>

    
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('frontend/js/jquery.validate.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
    	$("#signupForm").validate({
            rules: {
                loai: "required",      
            },
            messages: {
                loai: "Chọn loại gas",
            },
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback-staff");
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