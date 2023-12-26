<div style="width:680px; margin: 0 auto">
    <div style="text-align: center;height: 63px; line-height: 60px; background-color: #77d020; border-radius: 2px; font-size: 16px; color: white;">
        <h4 >Thanh toán thành công</h4>
    </div>

    <div style="">
        <p style="font-size: 15px;">Xin chào {{$user->name}}</p>
    </div>

    <div style="display: flex; font-size: 15px;">
        <div style="flex: 0 0 auto; width: 45%;">
            <strong style="padding-bottom: 1.5rem; padding-right: 0.25rem">Mã đơn hàng: </strong>
            <span style="background-color: #ffc107; height: 27px !important; ">{{$order->order_code}}</span>
        </div>
    </div>

    <div style="display: flex; font-size: 15px;">
        <div style="flex: 0 0 auto; width: 45%;">
            <strong style="padding-bottom: 1.5rem; padding-right: 0.25rem">Thành tiền:: </strong>
            <span style="color: red; height: 27px !important; ">{{number_format($order->tong)}} VNĐ</span>
        </div>
    </div>

    <div style="text-align: center; font-size: 15px;">
        Mọi thắc mắc xin liên hệ: <a href="">0837641469</a>
    </div>

</div>
