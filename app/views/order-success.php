<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng thành công</title>
    <link rel="stylesheet" href="assets/css/order-success.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./app/assets/font/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-order-success">
        <div class="info-user">
            <h2>Thông tin người nhận</h1>
            <p>Họ tên: <span id="fullname"></span></p>
            <p>Số điện thoại: <span id="phone"></span></p>
            <p>Địa chỉ: <span id="address"></span></p>
        </div>
        <div class="info-product">
            <h2>Thông tin sản phẩm</h1>
            <div id="productList">

            </div>
            <p style="float: right; font-size: 18px; padding: 8px;" class="totalPrice">
                Thành tiền: <span style="color: #e94560;font-weight: 600; " id="totalPrice"></span>
            </p>
        </div>
        <div class="info-order">
            <h2>Thông tin đơn hàng</h1>
            <p>Mã đơn hàng: <span id="orderId"></span></p>
            <p>Ngày đặt hàng: <span id="orderDate"></span></p>
            <p>Trạng thái: <span style="color: #ea7852;" id="orderStatus"></span></p>
            <p>Phương thức thanh toán: <span id="paymentMethod"></span></p>
            <!-- <p>Tổng tiền: <span id="totalPrice"></span></p> -->
            
        </div>
        <a href="/" style="color: #007bff;padding: 0 30px;padding-bottom: 20px; font-size: 16px;">Quay lại trang chủ</a>
    </div>
    <script src="/app/assets/js/order-success.js?v=1.1"></script>
</body>
</html>