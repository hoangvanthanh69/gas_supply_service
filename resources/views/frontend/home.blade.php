<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Gas Tech</title>
    <link rel="icon" type="image/png" href="{{asset('frontend/img/kisspng-light-fire-flame-logo-symbol-fire-letter-5ac5dab338f111.3018131215229160192332.jpg')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/index.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="grid">
            <div class="header-with">
                <div class="logo-gas-gas">
                    <img src="{{asset('frontend/img/kisspng-light-fire-flame-logo-symbol-fire-letter-5ac5dab338f111.3018131215229160192332.jpg')}}" class="" alt="...">
                </div>
                <div class="header-with-logo">
                    <a href="#" class="header-with-logo__name">
                        <strong class="logo-name-gas">
                            Gas
                        </strong>
                        Tech
                    </a>
                </div>

                <!-- <div class="header-with-search"> -->
                    <div class="header-with-search-header">
                        <form action="" method="POST" id="input_filter" class="header-with-search-form"></form>
                            <i class="header-with-search-icon fas fa-search"></i>
                            <input type="text" id="search_item" name="fullname" autocapitalize="off" class="header-with-search-input" placeholder="Nhập để tìm kiếm">

                        </form>
                    </div>
                <!-- </div> -->

                <div class="header-criteria">
                    <h3 class="header-criteria-h3">Nhanh chóng</h3>
                    <p class="header-criteria-p">Uy tính</p>
                </div>

                <div class="header-criteria-quality">
                    <h3 class="header-criteria-h3">Chất lượng</h3>
                    <p class="header-criteria-p">Đảm bảo</p>
                </div>

                <div class="header-criteria-quality">
                    <h3 class="header-criteria-h3">Miễn phí</h3>
                    <p class="header-criteria-p">Giao hàng</p>
                </div>

                <div class="nav-item dropdown ml-2 nav-item-name-user">
                    @if (Session::get('home'))
                        <p href="#" aria-expanded="true" id="dropdownMenuAcc" data-bs-toggle="dropdown" class="nav-item nav-link user-action header-criteria-h3 name-login-user">
                            @if ($users -> img)
                                <img class="customer-account-image" src="{{ asset('uploads/users/' . $users->img) }}" alt="">
                            @else
                                <img src="{{ asset('frontend/img/logo-login.png') }}" alt="..." width="60px">
                            @endif
                            {{ $users -> name }}
                        </p>
                    @endif
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuAcc">
                        <div class="">
                            <div class="header-with-account-span">
                                <li class="">
                                    @if (Session::get('home'))
                                        <p href="#" aria-expanded="true" id="dropdownMenuAcc" data-bs-toggle="dropdown" class="info-name-account-customer">
                                            @if ($users -> img)
                                                <img class="ms-2 img-customer-manages-account" src="{{ asset('uploads/users/' . $users->img) }}" alt="" width="40px" height="50px">
                                            @else
                                                <img class="ms-2" src="{{ asset('frontend/img/logo-login.png') }}" alt="..." width="40px">
                                            @endif
                                            <span class="ps-2">{{ $users -> name }}</span>
                                        </p>
                                    @endif
                                </li>

                                <div class="header-with-account-li">
                                    <li>
                                        <a class="" data-bs-toggle="modal" href="#exampleModalToggle" role="button">
                                            <i class="fa-solid fa-gear me-2 ps-4"></i>
                                            Quản lý tài khoản
                                        </a>
                                    </li>

                                    <li class="mt-2 mb-2">
                                        <a href="{{route('logoutuser')}}">
                                            <i class="fa-solid fa-power-off me-2 ps-4"></i>
                                            Đăng xuất
                                        </a>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal thông tin thay đổi tài khoản -->
                    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalToggleLabel">Thông tin tài khoản</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    @if (Session::get('home'))
                                        <div class="modal-account-users">
                                            <div class="text-center mb-3">
                                                @if ($users -> img)
                                                    <img class="customer-account-image-modal" src="{{ asset('uploads/users/' . $users->img) }}" alt="" width="60px">
                                                @else
                                                    <img src="{{ asset('frontend/img/logo-login.png') }}" alt="..." width="60px">
                                                @endif
                                            </div>

                                            <div class="d-flex mb-3">
                                                <label class="text-acount-customer col-3" for="">Họ tên:</label>
                                                <span class="ps-3">{{ $users -> name }}</span>
                                            </div>
                                            <div class="d-flex mb-3">
                                                <label class="text-acount-customer col-3" for="">Tài khoản:</label>
                                                <span class="ps-3">{{ $users -> email }}</span>
                                            </div>
                                            <div class="d-flex mb-3">
                                                <label class="text-acount-customer col-3" for="">Số điện thoại:</label>
                                                <span class="ps-3">{{ $users -> phone }}</span>
                                            </div>
                                            <div class="d-flex mb-3">
                                                <label class="text-acount-customer col-3" for="">Mật khẩu:</label>
                                                <span class="ps-3 mt-1 fs-5">{{ str_repeat('*', 8) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!--modal click hiển thị thay đổi mật khẩu -->
                                <div class="modal-change-password">
                                    <a href="" class="" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal" data-bs-dismiss="modal">Đổi mật khẩu</a>
                                    <a href="" class="" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Cập nhật tài khoản</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--cập nhật lại thông tin -->
                    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalToggleLabel2">Cập nhật thông tin tài khoản</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body ms-4 me-4 mb-3">
                                    <form enctype="multipart/form-data" method="post" action="{{route('update_image_user', $users->id) }}">
                                        @csrf
                                        <div class="row">
                                            <label class="name-add-product-all col-4" for="">Thay đổi ảnh:</label>
                                            <input class=" col-6 input-add-img-customer " type="file" name="img">
                                            @if ($users -> img)
                                                <img class="img-change-customer col-2" src="{{ asset('uploads/users/' . $users->img) }}" alt="...">
                                            @else
                                                <img class="col-2" src="{{ asset('frontend/img/logo-login.png') }}" alt="..." width="60px">
                                            @endif
                                        </div>
                                                   
                                        <div class="row mt-3">
                                            <label class="name-add-product-all col-4" for="">Họ và Tên:</label>
                                            <input class="input-update-account-customer col-8" type="text" name="name" value="{{$users->name}}">
                                        </div>

                                        <div class="row mt-4">
                                            <label class="name-add-product-all col-4" for="">Tài khoản @:</label>
                                            <input class="input-update-account-customer col-8" type="text" name="email" value="{{$users->email}}">
                                        </div>

                                        <div class="row mt-4">
                                            <label class="name-add-product-all col-4" for="">Số điện thoại</label>
                                            <input class="input-update-account-customer col-8" type="text" name="phone" value="{{$users->phone}}">
                                        </div>
                                        <div class="save-img-customer text-center mt-4">
                                            <button class="save-img-customer" type="submit">Cập nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- cập nhật lại mk -->
                    <div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalToggleLabel3">Thay đổi mật khẩu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body ms-4">
                                    <form id="changepassforms" enctype="multipart/form-data" method="post" action="{{ route('update-password-customer', $users->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="col-5" for="">Nhập mật khẩu củ: 
                                                <span class="ms-1 color-required fw-bolder">*</span>
                                            </label>
                                            <input type="password" name="old_password" class="input-password-customer-change col-6 ps-2">
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-5" for="">Nhập mật khẩu mới: 
                                                <span class="ms-1 color-required fw-bolder">*</span>
                                            </label>
                                            <input type="password" name="new_password" id="new_password" class="input-password-customer-change col-6 ps-2">
                                        </div>
                                        <div  class="mb-3">
                                            <label class="col-5" for="">Nhập lại mật khẩu: 
                                                <span class="ms-1 color-required fw-bolder">*</span>
                                            </label>
                                            <input type="password" name="confirm_password" class="input-password-customer-change col-6 ps-2">
                                        </div>
                                        <div class="">
                                            <button class="save-password-customer" type="submit">Lưu mật khẩu</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="change-password-customer-home d-flex">
                            <i class="far fa-check-circle icon-check-success"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('mesage'))
                        <div class="success-customer-home-notification d-flex">
                            <i class="fas fa-ban icon-check-cancel"></i>
                            {{ session('mesage') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="grid-nav">
            <div class="grid-row-12">
                <div class="home-filter grid" id="filter_button">
                    <a href="{{route('home')}}" data-filter="all">
                        <button class="btnbtn home-filter-button actives" >
                        Trang chủ
                        </button>
                    </a>

                    <button class="btnbtn home-filter-button" data-filter="order_page">
                        Đổi gas
                    </button>

                    <button class="btnbtn home-filter-button" data-filter="guide">
                      Hướng dẫn đổi gas
                    </button>

                    <button class="btnbtn home-filter-button" data-filter="introduce">
                        Giới thiệu
                    </button>

                    <a href="{{route('order-history')}}">
                        <p class="header-cart-notice">{{ $counts_processing }}</p>
                        <button class="btnbtn home-filter-button" >
                            Lịch sử đơn hàng
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="web-container">
            <div class="marquee">
                <p>
                    <strong class="logo-name-gas">
                        Gas
                    </strong>
                    <strong>
                        Tech
                    </strong>
                    cung cấp các bình gas công nghiệp và gas dân dụng cho các nhà hàng, khách sạn, quán ăn gia đình...,
                    với tiêu chí “Nhanh chóng - An toàn - Chất lượng - Hiệu quả”.
                </p>
            </div>
            <div class="header-img-grid element_columns" data-item="img">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner ">
                        <div class="carousel-item active slide-main-carousel">
                            <img src="{{asset('frontend/img/qUWlvmuHovb77ZoDTOahjxDTYkzQsqVWP0Ar1UEP.jpg')}}" class="slide-main d-block" alt="...">
                            <div class="gas-advertisement">
                                <div class="gas-advertisement-name ">
                                    <h1 class="gas-advertisement-name-h1">
                                        <span class="logo-name-gas">
                                            Gas
                                        </span>
                                        <span class="tech-name">
                                            Tech
                                        </span>giao gas công nghệ 24/7
                                    </h1>
                                </div>
    
                                <div>
                                    <p class="name-trademark">Nhanh chóng tiện lợi niềm tin của mọi nhà</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="carousel-item slide-main-carousel">
                            <img src="{{asset('frontend/img/banner_2.jpg')}}" class="slide-main d-block " alt="...">
                            <div class="gas-advertisement">
                                <div class="gas-advertisement-name ">
                                    <h1 class="gas-advertisement-name-h1 product-nav-span">
                                        </span class="">Sản phẩm chất lượng uy tính hàng đầu<span>
                                    </h1>
                                </div>
    
                                <div>
                                    <p class="name-trademark">Miễn phí giao hàng</p>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item slide-main-carousel">
                            <img src="{{asset('frontend/img/banner_3.jpg')}}" class="slide-main d-block " alt="...">
                            <div class="gas-advertisement">
                                <div class="gas-advertisement-name ">
                                    <h1 class="gas-advertisement-name-h1 product-nav-span">
                                        </span class=""><span>
                                    </h1>
                                </div>
    
                                <div>
                                    <p class="name-trademark"></p>
                                    <p class="text-info name-trademark"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="visually-hidden">Previous</span>
                    </button>
    
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="visually-hidden">Next</span>
                    </button>
    
                </div>
            </div>

            <!-- đổi gas -->
            <div class="grid element_column">
                <div class="gas-delivery infor">
                    <div class="card card-infor element_columns" data-item="order_page">
                        <div class="card-header card-heder-name">
                            <div class="card-header-name-change">
                                Đổi gas
                            </div>
                        </div>
                        <div class="card-body gas-delivery-information ">
                            <form id="signupForm" method="post" class="form-horizontal" action="{{route('order-product')}}">
                                @csrf
                                <div class="form-gas-delivery-information" >
                                    <label class="form-label" for="firstname">Tên khách hàng: 
                                        <span class="ms-1 color-required fw-bolder">*</span>
                                    </label>
                                    <input type="text" class="form-control form-product-specials nameCustomer" id="firstname" name="nameCustomer" value="{{ Session::get('home')['name'] }}" required/>
                                    <label class="form-label" for="number">Số điện thoại khách hàng:
                                        <span class="ms-1 color-required fw-bolder">*</span>
                                    </label>
                                    @if (empty($order_product))
                                        <input type="text" class="form-control form-product-specials phoneCustomer" id="number" name="phoneCustomer" value="{{ Session::get('home')['phone'] }}" />
                                    @else
                                        <input type="text" class="form-control form-product-specials phoneCustomer" id="number" name="phoneCustomer" value="{{ $order_product[0]['phoneCustomer'] }}" />
                                    @endif
                                    <label for="exampleFormControlInput1" class="form-label" >Đỉa chỉ:
                                        <span class="ms-1 color-required fw-bolder">*</span>
                                    </label>
                                    <div class="delivery-location form-product-specials form-product-specials-location">
                                        @if (empty($order_product))
                                            <div >
                                                <select onchange="print_state('state',this.selectedIndex);" id="country" name="country" class="country form-select form-control special-product-address" aria-label="Default select example">
                                                </select>
                                            </div>
        
                                            <div>
                                                <select onchange="print_district('district',this.selectedIndex);" name="state" id="state" class="state form-select special-product-address product-address-district" aria-label="Default select example">
                                                </select>
                                            </div>
        
                                            <div>
                                                <select name="district" id="district" class="district form-select special-product-address product-address-district" aria-label="Default select example">
                                                </select>
                                            </div>

                                            <div>
                                                <textarea name="diachi" type="resize:none" class="diachi form-control special-product-address-input special-product-address product-address-district" id="exampleFormControlInput1" placeholder="địa chỉ nhà cụ thể" cols="30" rows="10"></textarea>
                                            </div>
                                        @else
                                            <div id="address">
                                                <div>
                                                    <span class="adress-customer-span">{{$country}}, {{$state}}, {{$district}}, {{$diachi}}</span>
                                                </div>
                                                <div id="change-address">Thay đổi địa chỉ:</div>
                                                <div class="select-address-user hidden">
                                                    <div class="change-addres-user-select">
                                                        <div>
                                                            <select onchange="print_state('state',this.selectedIndex);" id="country" name="country" class="country form-select form-control special-product-address" aria-label="Default select example">
                                                            </select>
                                                        </div>
                    
                                                        <div>
                                                            <select onchange="print_district('district',this.selectedIndex);" name="state" id="state" class="state form-select special-product-address product-address-district" aria-label="Default select example">
                                                            </select>
                                                        </div>
                    
                                                        <div>
                                                            <select name="district" id="district" class="district form-select special-product-address product-address-district" aria-label="Default select example">
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <textarea name="diachi" type="resize:none" class="diachi form-control special-product-address-input special-product-address product-address-district" id="exampleFormControlInput1" placeholder="địa chỉ nhà cụ thể" cols="30" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <label for="loai" class="form-label">Loại bình gas:
                                        <span class="ms-1 color-required fw-bolder">*</span>
                                    </label>
                                    <div class="delivery-location form-product-specials product-type">
                                        <div class="d-flex">
                                            <div class="col-8">
                                                <select class="form-select handle_order select-option" id="loai" name="loai" aria-label="Default select example" onchange="showProductsByType(this)">
                                                    <option value="">Chọn loại gas</option>
                                                    <option value="1" name="cn">Gas công nghiệp</option>
                                                    <option value="2" name="dd">Gas dân dụng</option>
                                                </select>
                                            </div>
                                            <div class="col-4 search-prodcut-order-phone">
                                                <i class="search-icon-discount fas fa-search"></i>
                                                <input type="text" autocapitalize="off" class="header-with-search-input-discount" placeholder="Tìm kiếm" name="search" id="searchInput" onkeyup="searchProducts(this.value)">
                                                <span class="header_search button" onclick="startRecognitions()">
                                                    <i class="fas fa-microphone" id="microphone-icon"></i> 
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="product-order-all btnt row" id="infor_gas">
                                            <!-- Thông tin sản phẩm sẽ được hiển thị -->
                                        </div>
                                    </div>
                                    

                                    <label for="exampleFormControlInput1" class="form-label ">Ghi chú:</label>
                                    <input class="ghichu form-control form-product-specials notie" id="exampleFormControlInput1" name="ghichu" cols="30" rows="10"></input>
                                    
                                    <div class="col-sm-5 offset-sm-4" id="show_infor">
                                        <div class="col-sm-5 offset-sm-4">
                                            <button class="btn btn-primary submit" id="view-order-info">Tiếp tục</button>
                                        </div>
                                    </div>

                                </div>

                                <!-- hiển thị thông tin đặt hàng trước khi đặt -->
                                <div class="modal fade ms-3" id="orderInfoModal" tabindex="-1" aria-labelledby="orderInfoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" >
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orderInfoModalLabel">Thông tin đặt hàng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body ms-3 me-3">
                                                <div class="infor-customer-order-div">
                                                    <span class="infor-customer-order">Tên khách hàng:</span>
                                                    <span id="nameCustomer" class=""></span>
                                                </div>
                                                <div class="infor-customer-order-div">
                                                    <span class="infor-customer-order">Số điện thoại: </span>
                                                    <span id="phoneCustomer" class=""></span>
                                                </div>
                                                <div class="infor-customer-order-div">
                                                    <span class="infor-customer-order">Loại gas: </span>
                                                    <span id="typeCustomer" class=""></span>
                                                </div>
                                                <div id="selectedProducts">
                                                <!-- Thông tin sản phẩm sẽ được thêm vào đây -->
                                                </div>

                                                <div>
                                                    <div class="infor-customer-order-div">
                                                        <i class="fas fa-tag sale-icon icon-sale-customer-online"></i>
                                                        <input oninput="applyCoupon()" type="text" placeholder="Nhập mã ưu đãi" name="coupon" id="coupon" class="input-coupon-customer-online" require>
                                                        <button type="button" oninput="applyCoupon()" class="btn-apply-code-sale">Áp dụng</button>
                                                    </div>

                                                    <div id="couponErrorMessage" class="text-danger"></div>
                                                    
                                                    <div class="infor-customer-order-div">
                                                        <span class="infor-customer-order">Giá trị giảm giá:</span>
                                                        <span id="discountAmount">0 VNĐ</span>
                                                        <input type="hidden" name="reduced_value" id="reduced_value" value="">
                                                    </div>

                                                    <div class="infor-customer-order-div">
                                                        <span class="infor-customer-order">Thành tiền:</span>
                                                        <span id="discountedTotal"></span>
                                                        <input type="hidden" name="tong" id="tong" value="">
                                                    </div>
                                                </div>

                                                <span class="text-warning">Miễn phí vận chuyển</span>
                                                <div class="modal-footers pt-3">
                                                    <button class="btn btn-primary submit" id="submitss">Thanh toán khi nhận hàng</button>
                                                    <button class="btn btn-success" type="" id="vnpayButton" name="redirect">Thanh toán 
                                                        <strong><span class="text-danger">VN</span>
                                                        <span class="vnpay-payment-customer">PAY</span></strong>
                                                    </button>
                                                    <input type="hidden" id="paymentOption" name="paymentOption" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- hướng dẫn đổi gas -->
            <div class="grid element_column">
                <div class="card card-support element_columns infor" data-item="guide">
                    <div class="card-header card-heder-name">
                        <div class="card-header-name-change">
                            Hướng dẫn
                        </div>
                    </div>
                    <div class="support-oder-product">
                        <ul class="support-oder-product-item">
                            <li class="support-oder-product-list">
                                <div class="icon-img">
                                    <img class="img-support-oder" src="https://gas24h.com.vn/themes/gas/ecommerce/images/icon-1.png" alt="">
                                </div>
    
                                <p class="support-text">
                                    <strong>Bước 1:</strong> 
                                    <br>
                                    Vào hệ thống website gastech.com
                                </p>
                            </li>
    
                            <li class="support-oder-product-list">
                                <div class="icon-img">
                                    <i class="fa-solid fa-hand-point-up"></i>
                                </div>
    
                                <p class="support-text">
                                    <strong>Bước 2:</strong> 
                                    <br>
                                    Click chọn ô đổi gas
                                </p>
                            </li >
    
                            <li class="support-oder-product-list">
                                <div class="icon-img">
                                    <i class="fa-solid fa-pencil"></i>
                                </div>
    
                                <p class="support-text">
                                    <strong>Bước 3:</strong> 
                                    <br>
                                    Điền các thông tin vào hệ thống 
                                </p>
                            </li>
    
                            <li class="support-oder-product-list">
                                <div class="icon-img">
                                    <img class="img-support-oder" src="https://gas24h.com.vn/themes/gas/ecommerce/images/icon-4.png" alt="">
                                </div>
    
                                <p class="support-text">
                                    <strong>Bước 4:</strong> 
                                    <br>
                                    Chọn đặt đơn hàng, kết thúc
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
            
            <!-- giới thiệu -->
            <div class="grid element_columns element_column" data-item="introduce">
                <div class="card card-support infor">
                    <div class="card-header card-heder-name">
                        <div class="card-header-name-change">
                            Giới thiệu
                        </div>
                    </div>
                    <div class="service-support-client">
                        <span>
                            <strong class="logo-name-gas">Gas</strong> 
                            <strong class="name-gas-tech">Tech</strong> cung cấp các bình gas công nghiệp và gas dân dụng cho các nhà hàng, khách sạn, nhà ăn gia đình..., dịch vụ chất lượng cao an toàn trên tiêu chí “Nhanh chóng - An toàn - Chất lượng - Hiệu quả” Tầm nhìn và sứ mệnh.
                        </span>
                        <ul >
                            <p class="service-client-strong">Dịch vụ:</p>
                            <li class="service-support-client-list">
                                Tư vấn, hướng dẫn miễn phí cho khách hàng.
                            </li>
                            <li class="service-support-client-list">
                                Giao gas nhanh chóng trong khoảng 30 phút, đáp ứng tối đa nhu cầu của quý khách.
                            </li>
                            <li class="service-support-client-list">
                                Đội ngũ kỹ thuật viên, nhân viên giao hàng giàu kinh nghiệm, nhiệt tình, được đào tạo bài bản mang lại hiệu quả cao.
                            </li>
                            <li class="service-support-client-list">
                                Website tiện lợi dễ dàng sử dụng cho mọi khách hàng.
                            </li>
                            <li class="service-support-client-list">
                                Luôn dành nhiều ưu đãi tốt nhất cho khách hàng thân thiết.
                            </li>
                            <li class="service-support-client-list">
                                Cam kết 100% bình gas mà Tech Gas cung cấp là sản phẩm chính hãng, có giấy chứng nhận chất lượng.
                            </li>
                            <li class="service-support-client-list">
                                Giúp khách hàng tiệt kiệm được nhiều thời gian, chỉ cần ở nhà đặt hàng gas sẽ mang tới cho bạn.
                            </li>
                            <li class="service-support-client-list">
                                Đạt được sự tín nhiệm của khách hàng và các đối tác chính là nhân tố quan trọng góp phần vào sự thành công của chúng tôi.
                            </li>
                           <li class="service-support-client-list">
                                Bạn muốn đổi gas chỉ cần lên Gastech.com website giao gas tiện lợi cho mọi khách hàng.
                           </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer">
            <div class="grid">
                <div class="grid-row grid-row-footer grid-row-footers">
                    <div class="home-row-column home-row-column-footer">
                        <div class="home-product-image home-product-image-footer">
                            <div class="contact">
                                <span class="contact-support">
                                    Hổ trợ khách hàng
                                </span>
                                <ul class="contact-support-list">
                                    <li class="contact-support-item">
                                        <i class="contact-support-item-icon-call fas fa-tty"></i>
                                        <a href="tel:0837641469" class="contact-support-item-call-link">
                                            <span>Tư vấn: </span>
                                            0837641469
                                        </a>
                                    </li>

                                    <li class="contact-support-item">
                                        <i class="text-warning fa-regular fa-envelope"></i>
                                        <a href="tel:0837641469" class="contact-support-item-call-link">
                                            hoangthanh@gmail.com
                                        </a>
                                    </li>

                                    <li class="contact-support-item">
                                        <a href="" class="contact-support-item-call-link">
                                            <i class="fa-solid fa-location-dot icon-location"></i>
                                        </a>
                                        <span class="contact-support-item-call contact-support-item-call-link">Đường 3/2, phường Xuân Khánh, quận Ninh Kiều, thành phố Cần Thơ</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="home-row-column home-row-column-footer">
                        <div class="home-product-image home-product-image-footer">
                            <div class="contact">
                                <span class="contact-support">
                                    Theo dõi chúng tôi trên
                                </span>
                                <ul class="contact-support-list">
                                    <li class="contact-support-item">
                                        <i class="contact-support-item-icon-facebook fab fa-facebook"></i>
                                        <a href="#" class="contact-support-item-call-link">
                                            Facebook
                                        </a>
                                    </li>
                                   
                                    <li class="contact-support-item">
                                        <i class="contact-support-item-icon-youtube fab fa-youtube"></i>
                                        <a href="#" class="contact-support-item-call-link">
                                            Youtube
                                        </a>
                                    </li>

                                    <li class="contact-support-item">
                                        <i class="contact-support-item-icon-instagram fa-brands fa-instagram"></i>
                                        <a href="#" class="contact-support-item-call-link">
                                            Instargram
                                        </a>
                                    </li>

                                    <li class="contact-support-item">
                                        <img src="{{asset('frontend/img/icon_google.png')}}" alt="" width="20px" height="20px">
                                        <a href="#" class="contact-support-item-call-link">
                                            GasTech.com
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="home-row-column home-row-column-footer">
                        <div class="home-product-image home-product-image-footer">
                            <div class="contact">
                                <span class="contact-support">
                                    Về chúng tôi
                                </span>
                                <ul class="contact-support-list">
                                    <li class="contact-support-item">
                                        <a href="" class="contact-support-item-call-link">
                                            Hướng dẫn mua hàng
                                        </a>
                                    </li>
                                    <li class="contact-support-item">
                                        <a href="#" class="contact-support-item-call-link">
                                            Giới thiệu
                                        </a>
                                    </li>

                                    <li class="contact-support-item">
                                        <a href="#" class="contact-support-item-call-link">
                                            Đổi gas
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="home-row-column home-row-column-footer">
                        <div class="home-product-image home-product-image-footer">
                            <div class="contact">
                                <h4 class="contact-support">
                                Liên hệ cửa hàng
                                </h4>
                                <!-- <div class="hot-line">
                                    <a href="tel:19001011">
                                        19001011
                                    </a>
                                </div> -->

                                <div class="mt-4">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.841454377098!2d105.7680403746508!3d10.029938972519625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0895a51d60719%3A0x9d76b0035f6d53d0!2zxJDhuqFpIGjhu41jIEPhuqduIFRoxqE!5e0!3m2!1svi!2s!4v1692107073014!5m2!1svi!2s" 
                                    width="250" height="150" style="border-radius: 6px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="footer-imge">
                    <div class="footer-imge-license footer-imge-user">
                        © HoangThanh
                    </div>
                </div>
            </div>
    </footer>
<!--  -->
    
<div class="contact-container">
    <div class="contact-close">

        <div class="close-heading-chat ">
            <span class="close-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
            <div class="text-center mt-1 fs-5 logo-name-tech-gas">Chat</div>
        </div>
    
        <div class="contact-show-message">
            <div class="message-customers">
                <form action="">
                    @csrf
                    <div id="message_show"></div>
                </form>
            </div>
        </div>

        <div class="message-submit-customer">
            <form action="" class="mt-3  d-flex">
                @csrf
                <div class="message-content-customer">
                    <input class="message_content message_content-textarea" id="message_content" name="message_content" placeholder="Aa"></input>
                </div>
                <button type="submit" class="button-send-message send-message">Gửi</button>
            </form>
        </div>
    </div>
</div>
<button class="contact-btn">Chat</button>
<!--  -->
    <a href="tel:0837641469">
        <div class="hotline">
            <span>Hotline</span>
            <span class="hotline-phone">19001011</span>
        </div>
    </a>
    <script src="{{asset('frontend/js/style.js')}}"></script>
    <script src="{{asset('frontend/js/doigas.js')}}"></script>
    <script language="javascript">print_country("country");</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{asset('frontend/js/jquery.validate.js')}}"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate({
				rules: {
					nameCustomer:{required: true, maxlength: 30},
					phoneCustomer:{required: true, maxlength: 11, minlength: 10, number: true,},
					country: "required",
                    state: "required",
                    district: "required",
                    diachi: {required: true, maxlength: 30},
                    loai: "required",
                    ghichu:{maxlength: 30},
				},
				messages: {
					nameCustomer:{
						required: "Nhập tên",
						maxlength: "Nhập tên ngắn hơn"
					},
					phoneCustomer: {
						required: "Nhập số điện thoại",
						maxlength: "Không đúng định dạng",
                        minlength: "Không đúng định dạng",
                        number: "Vui lòng nhập số",
					},
					country: "Nhập địa chỉ",
					state: "Nhập huyện",
					district: "Nhập phường/xã",
					diachi: {
						required: "Nhập hẻm / số nhà",
						maxlength: "Nhập ngắn hơn"
					},
                    loai: "Chọn loại gas",
                    ghichu:{
						maxlength: "Nhập ghi chú ngắn hơn"
					},
				},
				errorElement: "div",
				errorPlacement: function (error, element) {
					error.addClass("invalid-feedback");
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

    <script>
        var notificationClasses = [
            '.change-password-customer-home',
            '.success-customer-home-notification',
        ];
        function showContent() {
            notificationClasses.forEach(function(classname) {
                var contentBox = document.querySelector(classname);
                if (contentBox) {
                    contentBox.classList.add('show');
                    setTimeout(function() {
                        contentBox.classList.remove('show');
                    }, 6000); 
                }
            });
        }
        @if(session('success'))
            showContent();
        @endif

        @if(session('mesage'))
            showContent();
        @endif
    </script>

    <script type="text/javascript">
		$(document).ready(function(){
			$("#changepassforms").validate({
				rules: {
					old_password: "required",
                    new_password: {required: true, minlength: 5},
                    confirm_password: {required: true, minlength: 5, equalTo: "#new_password"},
				},
				messages: {
					old_password: "Nhập mật khẩu củ",
                    new_password: {
						required: "Bạn chưa nhập mật khẩu",
						minlength: "Mật khẩu phải có ít nhất 5 kí tự"
					},
                    confirm_password: {
						required: " Bạn chưa nhập mật khẩu",
						minlength: "Mật khẩu phải có ít nhất 5 ký tự",
						equalTo: "Mật khẩu không trùng khớp với mật khẩu đã nhập",
					},
				},
				errorElement: "div",
				errorPlacement: function (error, element) {
					error.addClass("invalid-feedbacks");
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

    <script>
       window.onload = function() {
            var adsText = document.getElementById('adstext');
            var adsContainer = document.getElementById('adscontainer');
            var adsContainerWidth = adsContainer.offsetWidth;
            var adsTextWidth = adsText.offsetWidth;
            if (adsTextWidth > adsContainerWidth) {
                adsText.style.animationDuration = (adsTextWidth / 50) + 's';
            } else {
                adsText.style.animation = 'none';
            }
        };
    </script>

    <script>
        var selectedProducts = [];
            function showProductsByType(selectElement) {
                var selectedType = selectElement.value;
                var inforGasDiv = document.getElementById("infor_gas");
                inforGasDiv.innerHTML = "";
                var filteredProducts = <?php echo json_encode($products); ?>.filter(product => product.loai == selectedType);
                for (var i = 0; i < filteredProducts.length; i++) {
                    var product = filteredProducts[i];
                    var html = `
                        <div class="col-3 image-product-order-all productchoose border border-secondary mt-2" id="${product.id}" onclick="highlightProduct(this)">
                            ${product.quantity == 0 ? 
                                '<div class="home-product-item-sale-off"><span class="home-product-item-sale-off-label">Hết gas</span></div>' : ''
                            }
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" onchange="changeInputColor(this)">
                            </div>

                            <div class="activeq">
                                <img class="image-product-order" src="uploads/product/${product.image}" alt="" width="50%">
                            </div>

                            <div class="name-product-order">
                                Tên sản phẩm:
                                <span class="name_product name-product-span">${product.name_product}</span>
                            </div>

                            <div class="price-product-order price" id="price">
                                Giá sản phẩm:
                                <span class="original_price gia price-product-order-span">${numberFormat(product.price)} <span class="text-decoration-underline">đ</span> </span>
                            </div>
                            
                            <div class="d-flex mt-1">
                                <label class="col-7">Nhập số lượng:</label>
                                <input class="col-5" type="number" id="quantity" name="infor_gas[${product.id}]" data-id="${product.id}" onchange="updateProductQuantity(this)">
                            </div>
                        </div>
                    `;
                    inforGasDiv.innerHTML += html;
                }
            }
            function numberFormat(number) {
                return number.toLocaleString("vi-VN");
            }
            
            function updateProductQuantity(input) {
                var selectedProductId = input.getAttribute("data-id");
                var selectedProductQuantity = parseInt(input.value);
                for (var i = 0; i < selectedProducts.length; i++) {
                    if (selectedProducts[i].id === selectedProductId) {
                        selectedProducts[i].quantity = selectedProductQuantity;
                        break;
                    }
                }
                displaySelectedProducts();
            }

            function highlightProduct(element) {
                var selectedProductId = element.id;
                var selectedProductQuantity = parseInt(element.querySelector("#quantity").value);
                console.log(selectedProductQuantity);
                var selectedProductName = element.querySelector(".name_product").textContent;
                var selectedProductPriceText = element.querySelector(".price").textContent;
                var selectedProductPrice = parseFloat(selectedProductPriceText.replace(/\D/g, ''));
                var checkbox = element.querySelector(".form-check-input");
                var isChecked = checkbox.checked;
                if (!isChecked) {
                    for (var i = 0; i < selectedProducts.length; i++) {
                        if (selectedProducts[i].id === selectedProductId) {
                            selectedProducts.splice(i, 1);
                            break;
                        }
                    }
                } else {
                    var selectedProduct = {
                        id: selectedProductId,
                        name: selectedProductName,
                        quantity: selectedProductQuantity,
                        price: selectedProductPrice
                    };
                    var isExist = false;
                    for (var i = 0; i < selectedProducts.length; i++) {
                        if (selectedProducts[i].id === selectedProductId) {
                            selectedProducts[i].quantity = selectedProductQuantity;
                            isExist = true;
                            break;
                        }
                    }
                    if (!isExist) {
                        selectedProducts.push(selectedProduct);
                    }
                }
                displaySelectedProducts();
            }
            function getProductByID(productId) {
                var filteredProducts = <?php echo json_encode($products); ?>;
                for (var i = 0; i < filteredProducts.length; i++) {
                    if (filteredProducts[i].id === productId) {
                        return filteredProducts[i];
                    }
                }
                return null;
            }

            function displaySelectedProducts() {
                var selectedProductsDiv = document.getElementById("selectedProducts");
                selectedProductsDiv.innerHTML = "";
                var totalPrice = 0;
                var key = 1;
                var html_thead = `
                <table class="table mb-1">
                    <thead>
                        <tr class="text-center">
                            <th class="col-1">#</th>
                            <th class="col-6">Sản phẩm</th>
                            <th class="col-2">Sl</th>
                            <th class="col-3">Giá</th>
                        </tr>
                    </thead>
                </table>
                `;
                selectedProductsDiv.innerHTML += html_thead;
                    for (var i = 0; i < selectedProducts.length; i++) {
                        var product = selectedProducts[i];
                        var productId = product.id;
                        var productName = product.name;
                        var productQuantity = product.quantity;
                        var productPrice = product.price;
                        var productTotalPrice = productQuantity * productPrice;
                        totalPrice += productTotalPrice;
                        var html = `
                            <table class="table">
                                <tbody>
                                    <tr class="text-center">
                                        <th class="col-1">${key++}</th>
                                        <td class="col-6">${productName}</td>
                                        <td class="col-2">${productQuantity}</td>
                                        <td class="col-3">${numberFormat(productPrice)} <span class="text-decoration-underline">đ</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        `;
                        selectedProductsDiv.innerHTML += html;
                    }
                var totalHTML = `
                    <div class="">
                        <span><span class="infor-customer-order">Tổng giá sản phẩm: </span>
                        <span class="selected-products-total fs-6">${numberFormat(totalPrice)}  VNĐ</span></p>
                    </div>
                `;
                selectedProductsDiv.innerHTML += totalHTML;
                document.getElementById("tong").value = totalPrice;
                document.getElementById("reduced_value").value = 0;
            }

            function applyCoupon() {
                var couponCode = document.getElementById("coupon").value;
                var totalPrice = calculateTotalPrice();
                var couponErrorMessage = document.getElementById("couponErrorMessage");
                $.ajax({
                    url: "{{ route('check-coupon') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon: couponCode
                    },
                    success: function(response) {
                        if (response.success) {
                            if (response.used) {
                                // Thông báo mã giảm giá đã sử dụng
                                couponErrorMessage.textContent = "Mã giảm giá đã được sử dụng!";
                                couponErrorMessage.style.display = "block";
                                document.getElementById("tong").value = totalPrice;
                                document.getElementById("reduced_value").value = 0;
                                updateDiscountedTotal(totalPrice, 0);
                                return;
                            } else {
                                // Tiến hành kiểm tra các điều kiện tiếp theo và tính toán giảm giá
                                var discountType = response.type;
                                var discountValue = response.gia_tri;
                                var discountQuantity = response.so_luong;
                                var discountStatus = response.status;
                                var discountPrerequisites = response.Prerequisites;
                                var discountedTotal = 0;

                                if (discountStatus === 1 && totalPrice >= discountPrerequisites) {
                                    if (discountType === 1) {
                                        var discountPercentage = discountValue;
                                        var discountAmount = (totalPrice * discountPercentage) / 100;
                                        discountedTotal = totalPrice - discountAmount;
                                    } else if (discountType === 2) {
                                        var discountAmount = discountValue;
                                        discountedTotal = totalPrice - discountAmount;
                                    }
                                } else if (discountStatus === 2) {
                                    couponErrorMessage.textContent = "Không có mã giảm giá!";
                                    couponErrorMessage.style.display = "block";
                                    updateDiscountedTotal(totalPrice, 0);
                                    return;
                                } else if (totalPrice < discountPrerequisites) {
                                    couponErrorMessage.textContent = "Tổng giá phải lớn hơn " + numberFormat(discountPrerequisites) + " VNĐ";
                                    couponErrorMessage.style.display = "block";
                                    updateDiscountedTotal(totalPrice, 0);
                                    return;
                                }

                                if (discountQuantity > 0) {
                                    $.ajax({
                                        url: "{{ route('notification-discount-quantity') }}",
                                        method: "POST",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            coupon: couponCode
                                        },
                                        success: function() {
                                            // Thực hiện cập nhật số lượng giảm giá thành công
                                            updateDiscountedTotal(discountedTotal, discountAmount);
                                            couponErrorMessage.style.display = "none";
                                        },
                                        error: function(xhr, status, error) {
                                            // Xử lý lỗi
                                        }
                                    });
                                } else {
                                    // Hiển thị thông báo khi số lượng giảm giá bằng 0
                                    document.getElementById("discountAmount").textContent = "0 VNĐ";
                                    document.getElementById("discountedTotal").textContent = numberFormat(totalPrice) + " VNĐ";
                                    couponErrorMessage.textContent = "Số lượng mã giảm giá đã hết!";
                                    couponErrorMessage.style.display = "block";
                                    updateDiscountedTotal(totalPrice, 0);
                                }
                            }
                        } else {
                            // Xử lý khi mã giảm giá không hợp lệ
                            updateDiscountedTotal(totalPrice, 0);
                            couponErrorMessage.textContent = "Không có mã giảm giá!";
                            couponErrorMessage.style.display = "block";
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi
                    }
                });
            }

            function updateDiscountedTotal(newTotal, discountAmount) {
                var formattedDiscountAmount = numberFormat(Math.round(discountAmount));
                var formattedNewTotal = numberFormat(newTotal);
                document.getElementById("tong").value = newTotal;
                document.getElementById("reduced_value").value = discountAmount;
                document.getElementById("discountAmount").textContent = formattedDiscountAmount + " VNĐ";
                document.getElementById("discountedTotal").textContent = formattedNewTotal + " VNĐ";
            }

            function calculateTotalPrice() {
                var totalPrice = 0;
                for (var i = 0; i < selectedProducts.length; i++) {
                    var product = selectedProducts[i];
                    totalPrice += product.quantity * product.price;
                }
                return totalPrice;
            }

            // tìm kiếm bằng giọng nói cho sản phẩm
            let isListening = false;
            function startRecognitions() {
                if (!isListening) {
                    isListening = true;
                    const recognition = new webkitSpeechRecognition();
                    recognition.continuous = false;
                    recognition.interimResults = false;
                    recognition.lang = 'vi-VN';
                    recognition.onresult = function(event) {
                        const transcript = event.results[0][0].transcript;
                        document.querySelector('.header-with-search-input-discount').value = transcript;
                        searchProducts(transcript);
                        isListening = false; 
                        document.querySelector('.header_search.button').classList.remove('listening');
                    };
                    recognition.onerror = function(event) {
                        console.error('Lỗi nhận dạng giọng nói:', event.error);
                        isListening = false; 
                        document.querySelector('.header_search.button').classList.remove('listening');
                    };
                    recognition.onend = function() {
                        isListening = false;
                        document.querySelector('.header_search.button').classList.remove('listening');
                    };
                    document.querySelector('.header_search.button').classList.add('listening');
                    recognition.start();
                }
            }

            // tìm kiếm sản phẩm
            function searchProducts(keyword) {
                var inforGasDiv = document.getElementById("infor_gas");
                var productsToShow = inforGasDiv.getElementsByClassName("productchoose");
                for (var i = 0; i < productsToShow.length; i++) {
                    var productName = productsToShow[i].querySelector(".name_product").textContent.toLowerCase();
                    if (productName.includes(keyword.toLowerCase())) {
                        productsToShow[i].style.display = "block";
                    } else {
                        productsToShow[i].style.display = "none";
                    }
                }
            }

            // hiển thị thông tin trước khi submit
            $(function() {
                $('#show_infor').on('submit', function(event) {
                    event.preventDefault();
                    var invalidQuantity = false;
                    var invalidLoai = false;
                    var selectedProductCount = 0;
                    for (var i = 0; i < selectedProducts.length; i++) {
                        var product = selectedProducts[i];
                        if (product.quantity < 0 || isNaN(product.quantity)) {
                            invalidQuantity = true;
                        } else if (product.quantity > 0) {
                            selectedProductCount++;
                        }
                    }
                    var selectedLoai = $('#loai').val();
                    if (selectedLoai == 0) {
                        invalidLoai = true;
                    }
                    if (invalidQuantity && invalidLoai) {
                        alert("Vui lòng chọn ít nhất một sản phẩm và loại gas");
                        return;
                    } else if (invalidQuantity) {
                        alert("Vui lòng nhập số lượng hợp lệ cho sản phẩm đã chọn");
                        return;
                    } else if (invalidLoai) {
                        alert("Vui lòng chọn loại gas");
                        return;
                    }
                    if (selectedProductCount === 0) {
                        alert("Vui lòng chọn ít nhất một sản phẩm");
                        return;
                    }
                    var nameCustomer = $('#firstname').val();
                    var phoneCustomer = $('#number').val();
                    var typeCustomer = $('#loai option:selected').text();
                    var ghichuCustomer = $('.ghichu').val();
                    $('#nameCustomer').text(nameCustomer);
                    $('#phoneCustomer').text(phoneCustomer);
                    $('#typeCustomer').text(typeCustomer);
                    $('#orderInfoModal').modal('show');
                });
                $('#view-order-info').on('click', function(event) {
                    event.preventDefault();
                    $('#show_infor').submit();
                });
            });

            function changeInputColor(checkbox) {
                var parentDiv = checkbox.closest('.image-product-order-all');
                if (checkbox.checked) {
                    parentDiv.style.backgroundColor = '#d8ded8';
                } else {
                    parentDiv.style.backgroundColor = '';
                }
            }

            // Xử lý sự kiện nút thanh toán khi nhận hàng
            document.getElementById("submitss").addEventListener("click", function() {
                document.getElementById("paymentOption").value = "payOnDelivery";
            });

            // Xử lý sự kiện nút thanh toán VNPay"
            document.getElementById("vnpayButton").addEventListener("click", function() {
                document.getElementById("paymentOption").value = "vnpay";
            });

            document.addEventListener("DOMContentLoaded", function() {
                var vnpayButton = document.getElementById("vnpayButton");
                var totalPriceElement = document.getElementById("tong"); // Trường input ẩn
                vnpayButton.addEventListener("click", function() {
                    var totalPrice = parseFloat(totalPriceElement.value); // Lấy giá trị từ trường input ẩn
                    // Tạo form ẩn và gắn vào body
                    var form = document.createElement("form");
                    form.setAttribute("method", "POST");
                    form.setAttribute("action", "{{ route('vnpay_payment') }}");
                    form.style.display = "none";

                    // Thêm input hidden
                    var tongField = document.createElement("input");
                    tongField.setAttribute("type", "hidden");
                    tongField.setAttribute("name", "tong");
                    tongField.setAttribute("id", "tong");
                    tongField.setAttribute("value", totalPrice);
                    form.appendChild(tongField);

                    // Thêm CSRF token
                    var csrfField = document.createElement("input");
                    csrfField.setAttribute("type", "hidden");
                    csrfField.setAttribute("name", "_token");
                    csrfField.setAttribute("value", "{{ csrf_token() }}");
                    form.appendChild(csrfField);

                    // Thêm tham số redirect
                    var redirectField = document.createElement("input");
                    redirectField.setAttribute("type", "hidden");
                    redirectField.setAttribute("name", "redirect");
                    redirectField.setAttribute("value", "1");
                    form.appendChild(redirectField);

                    // Gắn form vào body
                    document.body.appendChild(form);
                    form.submit();
                });
            });

            $('#staticBackdrop').on('shown.bs.modal', function () {
                $('#orderInfoModal').modal('hide');
            });
    </script>

    <script>
        $(document).ready(function() {
            load_message();
            function load_message() {
                $.ajax({
                    url: "{{ route('load-message') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#message_show').html(data);
                    },
                    error: function(xhr, status, error) {
                    }
                });
            }

            // thêm message
            $('.send-message').click(function(e){
                e.preventDefault();
                var message_content = $('.message_content').val();
                $.ajax({
                    url: "{{ route('send-message') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        message_content: message_content,
                    },
                    success: function(data) {
                        load_message();
                        $('.message_content').val('');
                    },
                    error: function(xhr, status, error) {

                    }
                });
            })

        });

    </script>

    <script>
        const contact_btn = document.querySelector('.contact-btn');
        const close_btn = document.querySelector('.close-btn');
        const contact_container = document.querySelector('.contact-container');
        contact_btn.addEventListener('click', () => {
            contact_container.classList.toggle('visibless')
        });
        close_btn.addEventListener('click', () => {
            contact_container.classList.remove('visibless')
        });

    </script>
</body>
</html>
