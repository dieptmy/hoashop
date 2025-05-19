<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    
    <div class="checkout-page container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="items">
                    <div class="infor item">
    
                        <div id="user-info" class="mb-4">
                            <h2 style="font-size: 20px;">Thông tin nhận hàng</h2>
                            <p><strong>Họ tên:</strong> <span id="fullname"></span></p>
                            <p><strong>Số điện thoại:</strong> <span id="phone"></span></p>
                            <p><strong>Địa chỉ:</strong> <span id="address"></span></p>
                            <!-- <p><strong>Quận/Huyện:</strong> <span id="district"></span></p>
                            <p><strong>Thành phố:</strong> <span id="city"></span></p> -->
                        </div>
                        <button id="edit-address" class="btn btn-secondary btn-sm">Thay đổi</button>
                    </div>
                    <div class="item">
                        <div class="payment-method-box">
                            <div class="payment-method-header">
                                <span>Hình thức thanh toán</span>
                            </div>
                            <div class="payment-method-content">
                                <span class="payment-label select">Thanh toán khi nhận hàng (COD)</span>
                                <a href="#" class="change-method" style="margin-left: 16px;">Thay đổi</a>
                            </div>
                            <div class="payment-method-list" style="display:none; margin-top: 10px;">
                                <div class="payment-method-item">
                                    <label class="radio-container" style="display:block;">
                                        <input type="radio" name="payment-method" value="cod" checked>
                                        <span class="custom-radio"></span>
                                        <span class="payment-label">Thanh toán khi nhận hàng (COD)</span>
                                    </label>
                                    <label class="radio-container" style="display:block;">
                                        <input type="radio" name="payment-method" value="credit_card">
                                        <span class="custom-radio"></span>
                                        <span class="payment-label">Chuyển tiền qua ngân hàng</span>
                                    </label>
                                    <label class="radio-container" style="display:block;">
                                        <input type="radio" name="payment-method" value="paypal">
                                        <span class="custom-radio"></span>
                                        <span class="payment-label">Thanh toán qua PayPal</span>
                                    </label>
                                    <a href="#" class="save-method btn btn-outline-primary btn-sm" style="margin-top:10px;">Lưu</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <h2 style="font-size: 20px;">Sản phẩm bạn chọn</h2>
                        <div id="product-info"></div>
        
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Thông tin đơn hàng</h4>
                    <div class="summary-item">
                        <span>Tạm tính</span>
                        <span id="subtotal">0đ</span>
                    </div>
                    <div class="summary-item">
                        <span>Phí giao hàng</span>
                        <span>50.000đ</span>
                    </div>
                    <div class="summary-item total">
                        <span>Tổng</span>
                        <span id="total">0đ</span>
                    </div>
                    <button class="button-checkout" onclick="checkout()">THANH TOÁN NGAY</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal sửa địa chỉ -->
    <div id="editAddressModal" class="modal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);">
        <div class="modal-content" style="background:#fff;max-width:400px;margin:10vh auto;padding:24px;position:relative;">
            <h3>Sửa địa chỉ nhận hàng</h3>
            <label>Họ tên: <input type="text" id="editFullname" class="form-control"></label><br>
            <label>Số điện thoại: <input type="text" id="editPhone" class="form-control"></label><br>
            <label>Địa chỉ: <input type="text" id="editAddress" class="form-control"></label><br>
            <label>Thành phố:
                <select id="editCity" class="form-control">
                    <!-- <option value="">Chọn thành phố</option> -->
                </select>
            </label><br>
            <label>Quận/Huyện:
                <select id="editDistrict" class="form-control">
                    <option value="">Chọn quận/huyện</option>
                </select>
            </label><br>
            <div style="margin-top:12px; display: flex; justify-content: space-between;">
                <button id="cancelEditAddress" class="btn btn-outline-secondary">Hủy</button>
                <button id="saveAddress" class="btn btn-outline-danger">Lưu</button>
            </div>
        </div>
    </div>
    <script src="/app/assets/js/checkout.js?v=1.1"></script>
</body>
</html>


