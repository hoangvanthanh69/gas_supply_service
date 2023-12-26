@extends('layouts.admin_gas')
@section('sidebar-active-product', 'active' )
@section('content')

      <div class="col-10 nav-row-10 ">
        <div class="mb-4 product-list-staff-add">
          <span class="product-list-name fs-5">
            <a class="text-decoration-none color-logo-gas" href="{{route('quan-ly-sp')}}">Danh sách sản phẩm bán</a> / <a class="text-decoration-none color-name-admin-add" href="{{route('add-product-admin')}}">Thêm sản phẩm mới</a>
          </span>
        </div>
        <div class="add-staff-form">
          <div class="add-staff-heading-div">
            <span>Thêm sản phẩm mới</span>
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
          <form class="row container" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('add-product')}}">
            @csrf
            <div class="col-4">
              <span class="name-add-product-all" for="">Tên sản phẩm:
                <span class="color-required fw-bolder">*</span>
              </span>
              <input class="input-add-product ps-2 col-11 mt-2 ps-2 pe-2" type="text" name="name_product">
            </div>

            <div class="col-4">
              <span class="name-add-product-all" for="loai" class="form-label">Loại bình gas:
                <span class="color-required fw-bolder">*</span>
              </span>
              <div class="mt-2 p-0">
                <select id="loai" name="loai" class="input-add-product col-11 ps-2 pe-2" aria-label="Default select example">
                  <option value="">Chọn loại gas</option>
                  <option value="1" name="cn">Gas công nghiệp</option>
                  <option value="2" name="dd">Gas dân dụng</option>
                </select>    
              </div>
            </div>

            <div class="col-4">
              <span class="name-add-product-all" for="">Đơn vị:
                <span class="color-required fw-bolder">*</span>
              </span>
              <input class="input-add-product ps-2 col-11 mt-2 ps-2 pe-2" type="text" name="unit">
            </div>

            <div class="col-4 mt-3">
              <span class="name-add-product-all col-4 " for="">Thêm ảnh:
                <span class="color-required fw-bolder">*</span>
              </span>
              <input class="input-add-product name-add-product-all-img col-11 mt-2" type="file" name="image">
            </div>

            <div class="text-center mt-4">
              <a class="back-product" href="{{route('add-product-warehouse')}}">Trở lại thêm nhập kho</a>
              <a class="back-product" href="{{route('quan-ly-sp')}}">Trở lại kho sản phẩm</a>
              <button class="add-product button-add-product-save" type="submit">Lưu</button>
            </div>
          </form>
        </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('frontend/js/jquery.validate.js')}}"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate({
				rules: {
					name_product: {required: true, maxlength: 100},
					image: "required",
          loai: "required",
          unit: {required: true, maxlength: 30}
				},
				messages: {
					name_product: {
            required: "Nhập tên sản phẩm",
            maxlength: "Không quá 100 kí tự",
          },
					image: "Thêm ảnh",
          loai: "Chọn loại gas",
          unit: {
            required: "Nhập đơn vị",
            maxlength: "Không quá 30 kí tự",
          },
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
      </div>
    </div> 
  </div>