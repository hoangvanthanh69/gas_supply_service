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
<div class="all-customer-order-history">
    <div class="nav-status-history-customer">
        <div class="card-header-chitiet">
            <h4 class="product-list-name text-secondary">Đơn hàng của tôi</h4>
        </div>

        <div class="history-status-nav grid">
            <a href="?status=all" class="{{ ($status == 'all') ? 'activess' : '' }}">
                <div class="text-center">
                    <p class="header-order-history-status history-status-all">{{$counts_all}}</p>
                    <i class="fas fa-database fs-3 pb-2 status-all"></i>    
                    <p>Tất cả đơn hàng</p>
                </div>
            </a>

            <a href="?status=1" class="{{ ($status == '1') ? 'activess-1' : '' }}">
                <div class="text-center">
                    <p class="header-order-history-status history-status-handle">{{$counts_processing}}</p>
                    <i class="fas fa-spinner fs-3 pb-2 status-handle"></i>
                    <p>Đang xử lý</p>
                </div>
            </a>

            <a href="?status=2" class="{{ ($status == '2') ? 'activess-2' : '' }}">
                <div class="text-center">
                    <p class="header-order-history-status status-all history-status-delivery">{{$counts_delivery}}</p>
                    <i class="fas fa-car-side fs-3 pb-2 status-delivery"></i>
                    <p>Đang giao</p>
                </div>
            </a>

            <a href="?status=3" class="{{ ($status == '3') ? 'activess-3' : '' }}">
                <div class="text-center">
                    <p class="header-order-history-status status-all history-status-complete">{{$counts_complete}}</p>
                    <i class="fas fa-check-square fs-3 pb-2 status-complete"></i>    
                    <p>Đã giao</p>
                </div>
            </a>

            <a href="?status=4" class="{{ ($status == '4') ? 'activess-4' : '' }}">
                <div class="text-center">
                    <p class="header-order-history-status status-all history-status-cancel">{{$counts_cancel}}</p>
                    <i class="fas fa-window-close fs-3 pb-2 status-cancel"></i>    
                    <p>Đã hủy</p>
                </div>
            </a>
        </div>
    </div>

    <div class="history-list-order grid-history">
        <div class="row main-row container-fluid main-row-chitiet">
            <div class="product-list element_column" data-item="receipt">
                <div class="history-orders-list">
                    <div class="show-order-customer-date list-order-user-history-after">
                        <span>
                            Hiển thị:
                        </span>
                        <span>
                            <select class="selected-option-date-customer" aria-label="Default select example" onchange="filterOrderHistory(this.value)">
                                <option value="0" {{ ($filter == 0) ? 'selected' : '' }}>Tất cả đơn hàng</option>
                                <option value="5" {{ ($filter == 5) ? 'selected' : '' }}>5 ngày gần nhất</option>
                                <option value="10" {{ ($filter == 10) ? 'selected' : '' }}>10 ngày gần nhất</option>
                                <option value="30" {{ ($filter == 30) ? 'selected' : '' }}>30 ngày gần đây nhất</option>
                                <option value="180" {{ ($filter == 180) ? 'selected' : '' }}>6 tháng gần đây nhất</option>
                            </select>
                        </span>
                    </div>
                
                    @foreach($order_product as $key => $val)
                        @if ($status == 'all' || $val['status'] == $status)
                            <div class="row list-order-user-history list-order-user-history-after">
                                <div class="d-flex mt-3 justify-content-between infor-date-order-status">
                                    <div>Ngày đặt hàng 
                                        <span class="date-customer-order">{{$val['created_at']}}</span>
                                    </div>
                                    <div class="me-5 pe-5">
                                        Mã đơn hàng: 
                                        <span class="ms-2 text-warning">{{$val['order_code']}}</span>
                                    </div>
                                    <div class="status-order-user-history">
                                        <div>
                                            <?php 
                                                if ($val['status'] == 1) {
                                                    echo "<a href='" . route('cancel_order', ['id' => $val['id']]) . "'class='btn-cancel-order'>Hủy đơn</a>";
                                                    echo '<span class="border-span-status" style="color: orange;">Đang xử lý</span>';
                                                }
                                                else if ($val['status'] == 2) {
                                                    echo '<span class="border-span-status" style="color: #52de20;">Đang giao</span>';
                                                }
                                                else if ($val['status'] == 3) {
                                                    echo '<span class="border-span-status" style="color: #198754;">Đã giao</span>';
                                                }
                                                else if ($val['status'] == 4) {
                                                    echo '<span class="border-span-status" style="color: red;">Đã hủy</span>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('thong_tin_don_hang', $val['id'])}}" class="row link-infor-order-user-history">
                                    <div class="col-9 infor-order-user-history array-infor-order-user-history">
                                        @if (!empty($val['products']))
                                            @foreach ($val['products'] as $product)
                                                <div class="d-flex align-items-center">
                                                    <div class="col-2 infor-order-user-history">
                                                        <img class="image-admin-product-edit"  src="{{asset('uploads/product/'.$product['product']->image )}}" width="70%" height="70%" alt="">       
                                                    </div>
                                                    <div class="col-4">{{ $product['product_name']}}</div>
                                                    <div class="col-3 infor-order-user-history"><?php if($val['loai']==1){echo 'Gas công nghiệp';}else{echo 'Gas dân dụng';}  ?></div>
                                                    <div class="col-3">{{ number_format($product['product_price']) }} <span class="text-decoration-underline">đ</span></div>
                                                    <div class="col-2">Số lượng: {{ $product['quantity'] }}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <!-- <div class="col-2 infor-order-user-history"> Thành tiền:
                                        <span class="total-order-user-history">{{number_format($val['tong'])}} VNĐ</span>
                                    </div> -->
                                </a>
                            </div>
                        @endif
                    @endforeach
                    
                    @if (session('message'))
                        <div class="notification-orders">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="button-history-orders">
                        <a class="back-order-statistics" href="{{route('home')}}">
                            <i class="fa-solid fa-arrow-left"></i>
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
        <div class="footer">
            <div class="grid">
                <div class="grid-row grid-row-footer">
                    <div class="home-row-column">
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
                                            hthanh@gmail.com
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

                    <div class="home-row-column">
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
                                        <img src="{{asset('frontend/img/icon_instargram.png')}}" alt="" width="20px" height="20px">
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

                    <div class="home-row-column">
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

                    <div class="home-row-column">
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
<a href="tel:0837641469">
    <div class="hotline">
        <span>Hotline</span>
        <span class="hotline-phone">19001011</span>
    </div>
</a>
<!-- <script src="{{asset('frontend/js/style.js')}}"></script> -->
</body>
<script>
    function filterOrderHistory(filter) {
        window.location.href = '{{ route("order-history") }}?filter=' + filter;
    }
</script>
</html>