    <input type="hidden" id="product-card-info" data-product="" />
    <div id="addToCartModal" class="modal">
        <div class="modal-content modal-content-cart">
            <span class="close-modal">&times;</span>
            <h2>Thêm vào giỏ hàng</h2>
            <div class="product-info">
                <img id="modalProductImage" src="" alt="Product Image">
                <div class="product-details">
                    <h3 id="modalProductName"></h3>
                    <div class="price-info">
                        <p>Giá: <span id="modalUnitPrice">0đ</span></p>
                    </div>
                </div>
            </div>
            
            <div class="options">
                <p>Dung tích:</p>
                <div class="ml-options">
                    
                    <button class="ml-option" data-ml="10">10ml</button>
                    <button class="ml-option" data-ml="30">30ml</button>
                    <button class="ml-option" data-ml="50">50ml</button>
                    <button class="ml-option" data-ml="100">100ml</button>
                </div>
                
                <p>Số lượng:</p>
                <div class="quantity-control">
                    <button class="quantity-btn minus">-</button>
                    <input type="number" class="quantity-input" value="1" min="1" max="10">
                    <button class="quantity-btn plus">+</button>
                </div>

                <div class="total-price">
                    <p>Tổng tiền: <span id="modalTotalPrice">0đ</span></p>
                </div>
            </div>

            <div class="modal-buttons">
                <button class="cancel-btn">Hủy</button>
                <button class="confirm-btn">Xác nhận</button>
            </div>
        </div>
    </div>

    <div id="buyNowModal" class="modal-buy-now">
        <div class="modal-content-buy-now">
            <input type="hidden" id="product-card-buy-info" data-product="" />
            <span class="close-modal-buy-now">&times;</span>
            <h2>Mua ngay</h2>
            <div class="product-info-buy-now">
                <img id="modalProductImageBuyNow" src="" alt="Product Image">
                <div class="product-details-buy-now">
                    <h3 id="modalProductNameBuyNow"></h3>
                    <div class="price-info-buy-now">
                        <p>Giá: <span id="modalUnitPriceBuyNow">0đ</span></p>
                    </div>
                </div>
            </div>
            
            <div class="options-buy-now ">
                <p>Dung tích:</p>
                <div class="ml-options-buy-now">
                    <button class="ml-option-buy-now" data-ml="10">10ml</button>
                    <button class="ml-option-buy-now" data-ml="30">30ml</button>
                    <button class="ml-option-buy-now" data-ml="50">50ml</button>
                    <button class="ml-option-buy-now" data-ml="100">100ml</button>
                </div>
                
                <p>Số lượng:</p>
                <div class="quantity-control-buy-now">
                    <button class="quantity-btn-buy-now minus">-</button>
                    <input type="number" class="quantity-input-buy-now" value="1" min="1" max="10">
                    <button class="quantity-btn-buy-now plus">+</button>
                </div>

                <div class="total-price-buy-now">
                    <p>Tổng tiền: <span id="modalTotalPriceBuyNow">0đ</span></p>
                </div>
            </div>

            <div class="modal-buttons-buy-now" style="font-size: 14px;">
                <button class="cancel-btn cancel-btn-buy-now">Hủy</button>
                <button class="confirm-btn confirm-btn-buy-now buy-now-btn">Xác nhận</button>
            </div>
        </div>
    </div>
    <script src="/app/assets/js/xulydulieu.js"></script>