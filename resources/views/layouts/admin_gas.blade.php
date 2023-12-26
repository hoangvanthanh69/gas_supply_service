<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin</title>
      <link rel="icon" type="image/png" href="{{asset('frontend/img/kisspng-light-fire-flame-logo-symbol-fire-letter-5ac5dab338f111.3018131215229160192332.jpg')}}">
      <link rel="stylesheet" href="{{asset('backend/css/home_admin.css')}}">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   </head>

   <body>
      <div class="main ">
         <div class="row main-row container-fluid">
            <div class="col-2 nav-row-2">
               <div class="row-2-ul">
                  <ul class="nav flex-column ">
                     <div class="header-with-logo-name mb-2">
                        <strong class="logo-name-gas">
                           Gas
                        </strong>
                           Tech
                     </div>
                     <div class="img-admin-login mb-3">
                        @if (Session::has('admin_img'))
                           <img src="{{ asset('uploads/staff/' . Session::get('admin_img')) }}" alt="admin_img"  width="60px">
                        @endif
                     </div>
                     <div class="logout-admin">
                        <span>
                           Xin chào
                           @if (Session::get('admin'))
                              @if (isset(Session::get('admin')['admin_name']))
                                 {{ Session::get('admin')['admin_name'] }} !
                              @else
                                 <p>Welcome</p>
                              @endif
                           @endif
                        </span>

                        <span>
                           <a href="{{route('logout')}}">
                              <i class="fa-solid fa-right-from-bracket"></i>
                           </a>
                        </span>
                     </div>
                     
                     <?php if(Session::get('admin')['chuc_vu'] == "2"){?>
                        <div class="home-filter border-filet-butoon" id="filter_button">
                           <div class="btnbtn home-filter-button mb-1" data-filter="all">
                              <a class="@yield('sidebar-active-home')" href="{{route('admin')}}">
                                 <i class=" fa fa-home icon-all-admin-nav" aria-hidden="true"></i>
                                 Tổng quan
                              </a>
                           </div>
                           
                           <div class="" id="accordionFlushExample">
                              <div class="">
                                 <div id="flush-headingOne">
                                    <button class="accordion-button accordion-layouts-product " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" onclick="toggleArrow()">
                                       <div class="@yield('sidebar-active-product') @yield('sidebar-active-product-warehouse') @yield('sidebar-active-product-inventory') @yield('sidebar-active-supplier') d-flex" >
                                          <i class="fa-solid icon-product-layout icon-accordion-layouts fa-bars icon-all-admin-nav"></i>
                                          Quản lý sản phẩm
                                          <i class="fa-solid fa-angle-down ms-2 arrow-down"></i>
                                          <i class="fa-solid fa-angle-up ms-2 arrow-up"></i>
                                       </div>
                                       
                                    </button>
                                 </div>

                                 <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-product')" href="{{route('quan-ly-sp')}}">
                                          <i class="fas fa-box icon-product-layout icon-all-admin-nav"></i>
                                          Kho sản phẩm 
                                       </a>
                                    </div>

                                    <div class="mb-3 ms-4 home-filter-button fw-light" data-filter="product">
                                       <a class="@yield('sidebar-active-product-warehouse')" href="{{route('quan-ly-kho')}}">
                                          <i class="fa-solid fa-database icon-all-admin-nav"></i>
                                          Danh sách nhập kho
                                       </a>
                                    </div>

                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-product-inventory')" href="{{route('quan-ly-ton-kho')}}">
                                          <i class="fa-solid fa-warehouse icon-all-admin-nav"></i>
                                          Tồn kho sản phẩm
                                       </a>
                                    </div>

                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-supplier')" href="{{route('nha-cung-cap')}}">
                                          <i class="fa-solid fa-suitcase icon-all-admin-nav"></i>
                                          Nhà cung cấp
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="" id="accordionFlushExample">
                              <div class="">
                                 <div id="flush-headingTwo">
                                    <button class="accordion-button accordion-layouts-product pt-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo" onclick="toggleArrow()">
                                       <div class="@yield('sidebar-active-orders') @yield('sidebar-active-add-order') @yield('sidebar-active-giao-hang') d-flex" >
                                          <i class="fas fa-file-invoice-dollar icon-all-admin-nav icon-accordion-layouts"></i>
                                          Quản lý đơn hàng
                                          <i class="fa-solid fa-angle-down ms-2 arrow-down"></i>
                                          <i class="fa-solid fa-angle-up ms-2 arrow-up"></i>
                                       </div>
                                    </button>
                                 </div>

                                 <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-orders')" href="{{route('quan-ly-hd')}}">
                                          <i class="fa-regular fa-rectangle-list icon-all-admin-nav"></i>
                                          Danh sách đơn hàng
                                       </a>
                                    </div>

                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-add-order')" href="{{route('order_phone')}}">
                                          <i class="fa-solid fa-cart-plus icon-all-admin-nav"></i>
                                          Thêm đơn hàng mới
                                       </a>
                                    </div>

                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-giao-hang')" href="{{route('quan-ly-giao-hang')}}">
                                          <i class="fa-solid fa-truck icon-all-admin-nav"></i>
                                          Quản lý giao hàng
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="" id="accordionFlushExample">
                              <div class="">
                                 <div id="flush-headingFour">
                                    <button class="accordion-button accordion-layouts-product pt-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour" onclick="toggleArrow()">
                                       <div class="@yield('sidebar-active-customer') @yield('sidebar-active-shipper') d-flex" >
                                          <i class="fa-solid fa-people-group icon-all-admin-nav icon-accordion-layouts"></i>
                                          Quản lý nhân viên
                                          <i class="fa-solid fa-angle-down ms-2 arrow-down"></i>
                                          <i class="fa-solid fa-angle-up ms-2 arrow-up"></i>
                                       </div>
                                    </button>
                                 </div>

                                 <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-customer')" href="{{route('quan-ly-nv')}}">
                                          <i class="fas fa-clipboard-user icon-all-admin-nav"></i>
                                          Danh sách nhân viên
                                       </a>
                                    </div>
                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-shipper')" href="{{route('nhan-vien-giao-hang')}}">
                                          <i class="fa-solid fa-truck icon-all-admin-nav"></i>
                                          Quản lý nv giao hàng
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="btnbtn home-filter-button mb-4" data-filter="receipt">
                              <a class="@yield('sidebar-active-danh-gia-giao-hang')" href="{{route('danh-gia-giao-hang')}}">
                                 <i class="fa-solid fa-star icon-all-admin-nav"></i>
                                 Đánh giá giao hàng
                              </a>
                           </div>

                           <div class="btnbtn home-filter-button mb-4" data-filter="receipt">
                              <a class="@yield('sidebar-active-tai-khoan')" href="{{route('quan-ly-tk-admin')}}">
                                 <i class="fa-solid fa-lock icon-all-admin-nav"></i>
                                 Tài khoản quản trị
                              </a>
                           </div>

                           <div class="btnbtn home-filter-button mb-4" data-filter="receipt">
                              <a class="@yield('sidebar-active-tk-user')" href="{{route('quan-ly-tk-user')}}">
                                 <i class="fa-solid fa-user icon-all-admin-nav"></i>
                                 Quản lý khách hàng
                              </a>
                           </div>

                           <div class="btnbtn home-filter-button mb-4">
                              <a class="@yield('sidebar-active-discount')" href="{{route('quan-ly-giam-gia')}}">
                                 <i class="fa-sharp fa-solid fa-money-check-dollar icon-all-admin-nav"></i>
                                 Quản lý giảm giá
                              </a>
                           </div>

                           <div class="btnbtn home-filter-button mb-4">
                              <a class="@yield('sidebar-active-comment')" href="{{route('quan-ly-binh-luan')}}">
                                 <i class="fa-solid fa-comment icon-all-admin-nav"></i>
                                 Quản lý bình luận
                              </a>
                           </div>

                           <div class="btnbtn home-filter-button mb-2">
                              <a class="@yield('sidebar-active-message')" href="{{route('quan-ly-tin-nhan')}}">
                                 <i class="fa-solid fa-message icon-all-admin-nav"></i>
                                 Quản lý nhắn tin
                              </a>
                           </div>

                           <div class="" id="accordionFlushExample">
                              <div class="">
                                 <div id="flush-headingThree">
                                    <button class="accordion-button accordion-layouts-product " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseOne" onclick="toggleArrow()">
                                       <div class="@yield('sidebar-active-list-permissions') @yield('sidebar-active-permissions') @yield('sidebar-active-group-permissions') d-flex" >
                                          <i class="fa-solid fa-user-shield icon-all-admin-nav  icon-accordion-layouts"></i>
                                             Quản lý phân quyền
                                          <i class="fa-solid fa-angle-down ms-2 arrow-down"></i>
                                          <i class="fa-solid fa-angle-up ms-2 arrow-up"></i>
                                       </div>
                                       
                                    </button>
                                 </div>

                                 <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-list-permissions')" href="{{route('quan-ly-phan-quyen')}}">
                                          <i class="fa-solid fa-lock icon-all-admin-nav"></i>
                                          Danh sách phân quyền
                                       </a>
                                    </div>

                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-permissions')" href="{{route('danh-sach-quyen')}}">
                                          <i class="fa-solid fa-users-gear icon-all-admin-nav"></i>
                                          Danh sách quyền
                                       </a>
                                    </div>

                                    <div class="mb-3 ms-4 home-filter-button fw-light">
                                       <a class="@yield('sidebar-active-group-permissions')" href="{{route('danh-sach-nhom-quyen')}}">
                                          <i class="fa-solid fa-users-rays icon-all-admin-nav"></i>
                                          Danh sách nhóm quyền
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     <?php }

                     elseif(Session::get('admin')['chuc_vu'] == "3"){?>
                        <div class="btnbtn home-filter-button mb-4" data-filter="all">
                           <div class="mb-3 home-filter-button fw-light">
                              <a class="@yield('sidebar-active-product')" href="{{route('quan-ly-sp')}}">
                                 <i class="fas fa-box icon-product-layout icon-all-admin-nav"></i>
                                 Kho sản phẩm 
                              </a>
                           </div>

                           <div class="mb-3 home-filter-button fw-light" data-filter="product">
                              <a class="@yield('sidebar-active-product-warehouse')" href="{{route('quan-ly-kho')}}">
                                 <i class="fa-solid fa-database icon-all-admin-nav"></i>
                                 Danh sách nhập kho
                              </a>
                           </div>

                           <div class="mb-3 home-filter-button fw-light">
                              <a class="@yield('sidebar-active-product-inventory')" href="{{route('quan-ly-ton-kho')}}">
                                 <i class="fa-solid fa-warehouse icon-all-admin-nav"></i>
                                 Tồn kho sản phẩm
                              </a>
                           </div>

                           <div class="mb-3 home-filter-button fw-light">
                              <a class="@yield('sidebar-active-supplier')" href="{{route('nha-cung-cap')}}">
                                 <i class="fa-solid fa-suitcase icon-all-admin-nav"></i>
                                 Nhà cung cấp
                              </a>
                           </div>
                        </div>
                     <?php }

                     elseif(Session::get('admin')['chuc_vu'] == "1"){ ?>
                        <div class="btnbtn home-filter-button mb-4 " data-filter="all">
                           <div class="btnbtn home-filter-button" data-filter="receipt">
                              <a class="@yield('sidebar-active-orders')" href="{{route('quan-ly-hd')}}">
                                 <i class="fas fa-file-invoice-dollar"></i>
                                 Đơn hàng
                              </a>
                           </div>
                           <br>
                        </div>
                     <?php } ?>
                  </ul>
               </div>
            </div>

            @yield('content')

            <footer class="sticky-footer">
               <div class="container">
                  <div class="text-center">
                     <small>© HoangThanh</small>
                  </div>
               </div>
            </footer>
            
         </div>
      </div>
      </div>
      <script src="{{asset('backend/js/admin.js')}}"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <script>
         function toggleArrow(button) {
            var arrowDown = button.querySelector('.arrow-down');
            var arrowUp = button.querySelector('.arrow-up');
            arrowDown.classList.toggle('buttons');
            arrowUp.classList.toggle('buttons');
         }
         var buttons = document.querySelectorAll('.accordion-button');
         buttons.forEach(function(button) {
            button.addEventListener('click', function() {
               toggleArrow(button);
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
            
            @if(session('success') || session('message'))
               showContent();
            @endif
         </script>

   </body>
</html>