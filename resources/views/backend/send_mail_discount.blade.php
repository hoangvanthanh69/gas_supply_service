<div style="width:680px; margin: 0 auto">
    <div style="text-align: center;height: 63px; line-height: 60px; background-color: #77d020; border-radius: 2px; font-size: 16px; color: white;">
        <h4 >Gas Tech xin thông báo bạn có một mã giảm giá mới</h4>
    </div>

    <div style="">
        <p style="font-size: 15px;">Xin chào {{$customer->name}},</p>
    </div>

    <div style="">  
        <p style="font-size: 15px;">Gas Tech xin dành tặng bạn một giảm giảm giá <?php if ($add_discount['type'] == 1) {echo number_format($add_discount['gia_tri']) . '%';} else {echo number_format($add_discount['gia_tri']) . ' <span class="text-decoration-underline">đ</span>';}  ?> cho lần mua tiếp theo</p>
        <p style="font-size: 15px;">Sau đây là thông tin áp dụng mã <?php if ($add_discount['type'] == 1) {echo number_format($add_discount['gia_tri']) . '%';} else {echo number_format($add_discount['gia_tri']) . ' <span class="text-decoration-underline">đ</span>';}  ?></p>
    </div>

    <div>
        <ul>
            <li style="font-size: 15px;">Hạn áp dụng {{$add_discount->het_han}}</li>
            <li style="font-size: 15px;">Chiết khẩu <?php if ($add_discount['type'] == 1) {echo number_format($add_discount['gia_tri']) . '%';} else {echo number_format($add_discount['gia_tri']) . ' <span class="text-decoration-underline">đ</span>';}  ?> trên tổng đơn hàng</li>
            <li style="font-size: 15px;">Đơn hàng tối thiểu {{number_format($add_discount->Prerequisites)}} đ</li>
            <li style="font-size: 15px;">Mã giảm giá chỉ sử dụng một lần</li>
        </ul>
    </div>

    <div>
        <p style="font-size: 15px;">Trân trọng cảm ơn quý khách !</p>
    </div>

    <div style="font-size: 20px;">
        <p style="font-size: 20px; border: 1px solid; padding: 12px; border-radius: 16px; min-width: 70px; width: 130px; text-align: center;">
            {{$add_discount->ma_giam}}
        </p>
    </div>

    <div style="text-align: center; font-size: 15px;">
        Mọi thắc mắc xin liên hệ: <a href="">0837641469</a>
    </div>

</div>
