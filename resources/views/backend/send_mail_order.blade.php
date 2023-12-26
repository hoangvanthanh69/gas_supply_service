<div style="width:680px; margin: 0 auto">
    <div style="text-align: center;height: 63px; line-height: 60px; background-color: #77d020; border-radius: 2px; font-size: 16px; color: white;">
        <h4 >Gas Tech xin chân thành cảm ơn bạn đã đặt hàng</h4>
    </div>

    <div style="">
        <p style="font-size: 15px;">Xin chào {{$user->name}}</p>
    </div>

    <div style="">
        <p style="color: #ffcf00; font-size: 17px;">Địa chỉ nhận hàng:</p>
        <p style="color: #198754; font-size: 15px;">{{$order->nameCustomer}}</p>
        <p style="color: #198754; font-size: 15px;">(+84) {{$order->phoneCustomer}}</p>
        <p style="color: #312e2e; font-weight: 500; font-size: 15px;">{{$order->diachi}}, Phường {{$order->district}}, Quận {{$order->state}}, Thành Phố {{$order->country}}</p>
    </div>

    <div style="display: flex; font-size: 15px;">
        <div style="flex: 0 0 auto; width: 45%;">
            <strong style="padding-bottom: 1.5rem; padding-right: 0.25rem">Mã đơn hàng: </strong>
            <span style="background-color: #ffc107; height: 27px !important; ">{{$order->order_code}}</span>
        </div>
        <div style="padding-left: 1rem; flex: 0 0 auto; width: 30%;">
            <strong>Loại: </strong> {{$order->loai == 1 ? 'Gas công nghiệp' : 'Gas dân dụng'}}
        </div>
    </div>


    <div style="display: flex; ">
        <div style="flex: 0 0 auto; width: 60%; font-size: 15px;">
            <p style="font-size: 15px; text-align: center; font-weight: 600;">Thông tin sản phẩm:</p>
                <table style="width: 100%; margin-bottom: 1rem; color: #212529; border-color: #dee2e6;border-collapse: collapse;">
                    <thead style="border-width: 0;">
                        <tr style="border-color: inherit; border-style: solid; border-width: 1px 0; border-width: 1px 0; border-style: solid;">
                            <th style="border-width: 0 1px; border-color: inherit; border-style: solid;">Tên sản phẩm</th>
                            <th style="border-width: 0 1px; border-color: inherit; border-style: solid;">Số lượng</th>
                            <th style="border-width: 0 1px; border-color: inherit; border-style: solid;">Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: inherit; border-color: inherit; border-style: solid; border-width: 0;">
                    @foreach(json_decode($order->infor_gas) as $product)
                        <tr style="border-width: 1px 0; border-color: inherit; border-style: solid; border-width: 0; box-sizing: border-box;">
                            <td style="order-collapse: collapse; border-color: inherit; border-style: solid; border-width: 0 1px; padding: 0.5rem 0.5rem; background-color: var(--bs-table-bg); border-bottom-width: 1px;">{{$product->product_name}}</td>
                            <td style="order-collapse: collapse; border-color: inherit; border-style: solid; border-width: 0 1px; border-bottom-width: 1px; text-align: center;">{{$product->quantity}}</td>
                            <td style="order-collapse: collapse; border-color: inherit; border-style: solid; border-width: 0 1px; padding: 0.5rem 0.5rem; background-color: var(--bs-table-bg); border-bottom-width: 1px;">{{number_format($product->product_price)}} VNĐ</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            <!--  -->
        </div>

        <div style="flex: 0 0 auto; width: 40%; font-size: 15px; margin-left: 35px;">
            <p style="font-size: 15px; text-align: center; font-weight: 600;">Tổng Cộng:</p>
            <div style="display: flex;">
                <div style="flex: 0 0 auto; width: 60%;">
                    Phí vận chuyển: 
                </div>

                <div style="flex: 0 0 auto;width: 40%;">
                   miến phí
                </div>
            </div>

            <div style="display: flex; border-bottom: 1px solid #dee2e6; margin-top: -15px;">
                <div style="flex: 0 0 auto; width: 60%; line-height: 50px;">
                    Khuyến mãi giảm giá:
                </div>
                
                <div style="flex: 0 0 auto;width: 40%; line-height: 50px;">
                    {{number_format($order->reduced_value)}} VNĐ
                </div>
            </div>

            <div style="display: flex">
                <div style="flex: 0 0 auto; width: 60%; line-height: 50px;">
                    Thành tiền:
                </div>

                <div style="flex: 0 0 auto; width: 40%; line-height: 50px; color: red;">
                    {{number_format($order->tong)}} VNĐ
                </div>
            </div>
        </div>

    </div>

    <div style="font-size: 15px;">
        Ghi chú: {{$order->ghichu}}
    </div>

    <div style="text-align: center; font-size: 15px;">
        Mọi thắc mắc xin liên hệ: <a href="">0837641469</a>
    </div>

</div>
