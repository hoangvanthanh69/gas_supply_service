@extends('layouts.admin_gas')
@section('sidebar-active-add-order', 'active' )
@section('content')
    <div class="col-10">
        <div class="header-order-product mt-4">
            <div>
                <h5 class="color-logo-tech text-center padding-order-phone pt-3">Thêm đơn hàng mới từ số điện thoại</h5>
            </div>
            <div class="search-prodcut-order-phone header-with-search-form ">
            <i class="search-icon-discount fas fa-search"></i>
                <input type="text" autocapitalize="off" class="header-with-search-input header-with-search-input-discount" placeholder="Tìm kiếm" name="search" id="searchInput" onkeyup="searchProducts(this.value)">
                <span class="header_search button" onclick="startRecognitions()">
                    <i class="fas fa-microphone" id="microphone-icon"></i> 
                </span>
            </div>
        </div>

        @if (session('success'))
            <div class="change-password-customer-home d-flex">
                <i class="fas fa-ban icon-check-success"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('message'))
            <div class="success-customer-home-notification d-flex">
                <i class="fas fa-ban icon-check-cancel"></i>
                {{ session('message') }}
            </div>
        @endif
        <div class="row show-infor-product-orders container">
            <form class="row g-2" id="signupForm" enctype="multipart/form-data" method='post' action="{{route('add-order')}}">
                @csrf
                <div class="col-5 text-light ">
                    <div class="p-3 me-2 bg-order-product">
                        <div class="">
                            <label class="name-add-product-customer-all mb-1" for="">Số điện thoại:
                                <span class="text-danger fw-bolder">*</span>
                            </label>
                            <input class="infor-customer-input col-12" type="text" name="phoneCustomer" id="phoneCustomer">
                        </div>

                        <div class="mt-4">
                            <label class="name-add-product-customer-all mb-1" for="">Họ và Tên:
                                <span class="text-danger fw-bolder">*</span>
                            </label>
                            <input class="infor-customer-input col-12" type="text" name="nameCustomer" id="nameCustomer">
                        </div>

                        <div class="mt-4">
                            <label class="name-add-product-customer-all mb-1" for="">Đỉa chỉ:
                                <span class="text-danger fw-bolder">*</span>
                            </label>
                            <div class="d-flex address-customer-form">
                                <div>
                                    <input class="address-customer-input" type="text" name="country" id="country" placeholder="Tỉnh/TP">
                                </div>
                    
                                <div>
                                    <input class="address-customer-input" type="text" name="state" id="state" placeholder="Quận/Huyện">
                                </div>

                                <div>
                                    <input class="address-customer-input" type="text" name="district" id="district" placeholder="Phường/Xã">
                                </div>

                                <div>
                                    <textarea class="address-customer-input" type="text" name="diachi" id="diachi" placeholder="đia chỉ"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="name-add-product-customer-all mb-1" for="">Loại gas:
                                <span class="fw-bolder text-danger">*</span>
                            </label>
                            <div class= "p-0">
                                <select class="form-select handle_order select-option" id="loai" name="loai" aria-label="Default select example" onchange="showProductsByType(this)">
                                    <option value="">Chọn loại gas</option>
                                    <option value="1" name="cn">Gas công nghiệp</option>
                                    <option value="2" name="dd">Gas dân dụng</option>
                                </select> 
                            </div>
                                
                        </div>

                        <div class="mt-4">
                            <label class="name-add-product-customer-all mb-1" for="">Giảm giá:</label>
                            <div class= "p-0">
                                <select name="admin_name" id="admin_name" class="form-control form-select"  onchange="displaySelectedProducts()">
                                    <option value="">Chọn voucher</option>
                                        @foreach($tbl_discount as $discount)
                                            @if($discount -> status != 2)
                                                <option value="{{$discount->ma_giam}}">{{$discount -> ma_giam}} - {{number_format($discount -> gia_tri)}}</option>
                                                <!-- <input type="hidden" name="reduced_value" value="{{$discount -> gia_tri}}"> -->
                                            @endif
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="name-add-product-customer-all mb-1" for="">Ghi chú:</label>
                            <input class="infor-customer-input col-12" type="text" name="ghichu" id="ghichu">
                        </div>
                        
                        <div class="mt-4">
                            <div id="selectedProducts"></div>
                            <input type="hidden" name="tong" id="tong" value="">
                            <input type="hidden" name="reduced_value" id="reduced_value" value="">
                        </div>

                        <div class="mt-4 sumbmit-order-product" id="show_infor">
                            <div class="float-end ">
                                <button class="btn btn-submit-delivery submit" id="submitButton">Giao gas</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-7 pt-3 bg-order-product">
                    <div class="container ">
                        <div class="row g-2 product-order-all mb-3" id="infor_gas">
                            <div class="text-center">
                                <p class="color-show-infor-product fs-4">Hiển thị sản phẩm</p>
                                <!-- <i class="fa-solid fa-cart-shopping "></i> -->
                                <img class="infor-product-order-admin" src="{{asset('frontend/img/cart_shopping.jpg')}}" class="" alt="...">
                            </div>
                            <!-- Thông tin sản phẩm sẽ được hiển thị -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
@endsection
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('frontend/js/jquery.validate.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#phoneCustomer').on('blur', function() {
                var phoneNumber = $(this).val();
                $.ajax({
                    url: "{{ route('check-customer') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        phone: phoneNumber
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#nameCustomer').val(response.customerName);
                            $('#country').val(response.country);
                            $('#state').val(response.state);
                            $('#district').val(response.district);
                            $('#diachi').val(response.diachi);
                        } else {
                        // k hien thi gi het
                        }
                    },
                    error: function(xhr, status, error) {
                    }
                });
            });
        });
    </script>

    <script>
        var selectedProducts = [];
            function showProductsByType(selectElement) {
                var selectedType = selectElement.value;
                var inforGasDiv = document.getElementById("infor_gas");
                inforGasDiv.innerHTML = "";
                var allProducts = <?php echo json_encode($products); ?>;
                if (selectedType === "0") {
                    for (var i = 0; i < allProducts.length; i++) {
                        var product = allProducts[i];
                        var html = generateProductHTML(product);
                        inforGasDiv.innerHTML += html;
                    }
                } else {
                    var filteredProducts = allProducts.filter(product => product.loai == selectedType);
                    for (var i = 0; i < filteredProducts.length; i++) {
                        var product = filteredProducts[i];
                        var html = generateProductHTML(product);
                        inforGasDiv.innerHTML += html;
                    }
                }
            }

            function generateProductHTML(product) {
                var html = `
                    <div class="col-3 productchoose" id="${product.id}" onclick="highlightProduct(this)">
                        <div class="p-3 border-light image-product-order-all">
                            ${product.quantity == 0 ? 
                                '<div class="home-product-item-sale-off"><span class="home-product-item-sale-off-label">Hết gas</span></div>' : ''
                            }
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onchange="changeInputColor(this)">
                            </div>

                            <div class="image-product-order mb-2">
                                <img class="" src="uploads/product/${product.image}" alt="" width="50%">
                            </div>
                            <div class="name-product-order">
                                Sản phẩm:
                                <span class="name_product name-product-span">${product.name_product}</span>
                            </div>
                            <div class="price-product-order price" id="price">
                                Giá:
                                <span class="original_price gia price-product-order-span">${numberFormat(product.price)} đ</span>
                            </div>
                            
                            <div class="d-flex mt-1">
                                <label class="col-7">Số lượng:</label>
                                <input class="col-5 quatity-order-phone" type="number" id="quantity" name="infor_gas[${product.id}]" data-id="${product.id}" onchange="updateProductQuantity(this)">
                            </div>
                        </div>
                    </div>
                `;
                return html;
            }

            function numberFormat(number) {
                return number.toLocaleString("vi-VN");
            }


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
                var discountAmount = 0;
                var key = 1;
                var selectedVoucher = document.getElementById("admin_name").value;
                var tbl_discount = <?php echo json_encode($tbl_discount); ?>;

                for (var i = 0; i < selectedProducts.length; i++) {
                    var product = selectedProducts[i];
                    var productId = product.id;
                    var productName = product.name;
                    var productQuantity = product.quantity;
                    var productPrice = product.price;
                    var productTotalPrice = productQuantity * productPrice;
                    totalPrice += productTotalPrice;

                    var html = `
                        <div class="infor-customer-order-div mb-3 text-info">
                            <span class="infor-customer-order">Sản phẩm ${key++}: </span>
                            <span class="selected-product-name">${productName}, </span>
                            <span class="infor-customer-order">Số lượng: </span>
                            <span class="selected-product-quantity">${productQuantity}</span>
                        </div>
                    `;

                    selectedProductsDiv.innerHTML += html;
                }

                // Tính giảm giá dựa trên phần trăm của mã giảm giá
                var discountPercent = 0;
                var discountAmount = 0;

                // Kiểm tra nếu có mã giảm giá đã chọn
                if (selectedVoucher) {
                    for (var i = 0; i < tbl_discount.length; i++) {
                        var discount = tbl_discount[i];
                        if (discount.ma_giam === selectedVoucher) {
                            if(totalPrice >= discount.Prerequisites){
                                if (discount.type === 1) {
                                    discountPercent = discount.gia_tri;
                                    discountAmount = totalPrice * (discountPercent / 100);
                                } else if (discount.type === 2) {
                                    discountAmount = discount.gia_tri;
                                }
                            }
                            else{
                                discountAmount = 0;
                            }
                            break;
                        }
                    }
                }
                var tong = totalPrice - discountAmount;
                document.getElementById('tong').value = tong;
                document.getElementById('reduced_value').value = discountAmount;
                // console.log("Giá trị giảm giá:", discountAmount);
                // console.log("Phần trăm giảm giá:", discountPercent);
                var totalHTML = `
                    <div class="row mb-2">
                        <span class="col-4 infor-customer-order text-light fs-6">Tổng tiền hàng: </span>
                        <span class="col selected-products-total fs-6 text-light">${numberFormat(totalPrice)} đ</span>
                    </div>

                    <div class="row mb-2">
                        <span class="col-4 infor-customer-order text-light fs-6">Giảm giá: </span>
                        <span class="col selected-products-total fs-6 text-light">${numberFormat(Math.round(discountAmount))} đ</span>
                    </div>

                    <div class="row mb-2 border-button-order-phone-admin">
                        <span class="col-4 infor-customer-order text-light fs-6">Giao hàng: </span>
                        <span class="col selected-products-total fs-6 text-light">0 đ</span>
                    </div>

                    <div class="row">
                        <span class="col-4 infor-customer-order text-warning fs-5">Thành tiền: </span>
                        <span class="col selected-products-total fs-5 text-danger">${numberFormat(tong)} đ</span>
                    </div>
                    
                `;
                selectedProductsDiv.innerHTML += totalHTML;
            }


            function changeInputColor(checkbox) {
                var parentDiv = checkbox.closest('.image-product-order-all');
                if (checkbox.checked) {
                    parentDiv.style.backgroundColor = 'rgb(191 202 220)';
                } else {
                    parentDiv.style.backgroundColor = '';
                }
            }
    </script>

    <script type="text/javascript">
		$(document).ready(function(){
			$("#signupForm").validate({
				rules: {
					nameCustomer: {required: true, maxlength: 30},
					phoneCustomer: {required: true, maxlength: 11, minlength: 10, number: true},
					country: {required: true, maxlength: 30},
                    state: {required: true, maxlength: 30},
                    district: {required: true, maxlength: 30},
                    diachi: {required: true, maxlength: 30},
                    loai: "required",
                    ghichu:{maxlength: 30},
				},
				messages: {
					nameCustomer: {
						required: "Nhập tên",
						maxlength: "Nhập tên ngắn hơn"
					},
					phoneCustomer: {
						required: "Nhập số điện thoại",
						maxlength: "Không đúng định dạng",
                        minlength: "Không đúng định dạng",
                        number: "Vui lòng nhập số",
					},
					country: {
						required: "Nhập Tỉnh / TP",
						maxlength: "Nhập ngắn hơn"
					},
					state:{
						required: "Nhập Huyện",
						maxlength: "Nhập Huyện ngắn hơn"
					},
					district:{
						required: "Nhập Phường/Xã",
						maxlength: "Nhập Phường/Xã ngắn hơn"
					},
                    
					diachi:{
						required: "Nhập hẻm/số nhà",
						maxlength: "Nhập hẻm/số nhà ngắn hơn"
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
            $("#submitButton").on("click", function (event) {
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
                } else if (invalidQuantity) {
                    alert("Vui lòng nhập số lượng hợp lệ cho sản phẩm đã chọn");
                } else if (invalidLoai) {
                    alert("Vui lòng chọn loại gas");
                } else if (selectedProductCount === 0) {
                    alert("Vui lòng chọn ít nhất một sản phẩm");
                } else {
                    $("#signupForm").submit();
                }
            });
        });
	</script>
