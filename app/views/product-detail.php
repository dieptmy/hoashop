<!-- Product Detail Section -->
<div class="product-detail-container">
    <div class="container">
        <div class="row product-card-detail">
            <!-- Product Images -->
            <div class="col-md-6">
                <div class="product-images">
                    <div class="main-image">
                        <img id="productImage" src="" alt="Chanel N°5" class="img-fluid">
                    </div>
                    <!-- <div class="thumbnail-images">
                        <img src="assets/image/perfume-Img/img.in.canva/slide25-removebg-preview.png" alt="Chanel N°5" class="thumbnail active">
                        <img src="images/nu17.jpg" alt="Chanel N°5 Side View" class="thumbnail">
                        <img src="images/nu16.jpg" alt="Chanel N°5 Box" class="thumbnail">
                    </div> -->
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-md-6">
                <div class="product-info-detail">
                    <h1 id="productName"></h1>
                    
                    <div id="productPrice"></div>
                    
                    <div class="product-description">
                        <h3>Mô tả sản phẩm</h3>
                        <p id="productDescription"></p>
                    </div>

                    <div class="product-specifications">
                        <h3>Thông số kỹ thuật</h3>
                        <ul>
                            <li><strong>Dung tích:</strong> 100ml</li>
                            <li><strong>Nồng độ:</strong> Eau de Parfum</li>
                            <li><strong>Nhóm hương:</strong> Hoa cỏ - Aldehydic</li>
                            <li><strong>Hương đầu:</strong> Aldehydes, Bergamot, Lemon</li>
                            <li><strong>Hương giữa:</strong> Jasmine, Rose, Lily of the Valley</li>
                            <li><strong>Hương cuối:</strong> Vanilla, Amber, Sandalwood</li>
                            <li><strong>Thời gian lưu hương:</strong> 6-8 giờ</li>
                        </ul>
                    </div>

                    <div class="product-actions">
                        <!-- <div class="quantity-selector">
                            <button class="btn btn-outline-secondary" id="decrease-quantity">-</button>
                            <input type="number" value="1" min="1" id="quantity">
                            <button class="btn btn-outline-secondary" id="increase-quantity">+</button>
                        </div> -->

                        <div class="button">

                            <button class="btn btn-primary add-to-cart" id="add-to-cart" data-product-id="">Thêm vào giỏ</button>
                            <button class="btn btn-success buy-now" id="buy-now" data-product-id="">Mua ngay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-details-tabs mt-5">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Mô tả chi tiết</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ingredients-tab" data-bs-toggle="tab" data-bs-target="#ingredients" type="button" role="tab">Thành phần</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="usage-tab" data-bs-toggle="tab" data-bs-target="#usage" type="button" role="tab">Hướng dẫn sử dụng</button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <p>Đây là một trong những dòng nước hoa nữ nổi tiếng nhất thế giới, được tạo ra bởi Ernest Beaux vào năm 1921 theo yêu cầu của Coco Chanel. Đây là biểu tượng của sự sang trọng và nữ tính.</p>
                    <p>Với hương thơm độc đáo kết hợp giữa hoa cỏ và aldehydes, Chanel N°5 tạo nên một trải nghiệm hương thơm đầy quyến rũ và tinh tế. Sản phẩm được đựng trong chai thủy tinh tinh xảo với thiết kế đơn giản nhưng đầy tinh tế.</p>
                </div>
                <div class="tab-pane fade" id="ingredients" role="tabpanel">
                    <ul>
                        <li>Aldehydes</li>
                        <li>Bergamot</li>
                        <li>Lemon</li>
                        <li>Jasmine</li>
                        <li>Rose</li>
                        <li>Lily of the Valley</li>
                        <li>Vanilla</li>
                        <li>Amber</li>
                        <li>Sandalwood</li>
                    </ul>
                </div>
                <div class="tab-pane fade" id="usage" role="tabpanel">
                    <p>Để sử dụng nước hoa hiệu quả nhất:</p>
                    <ol>
                        <li>Xịt nước hoa cách cơ thể khoảng 15-20cm</li>
                        <li>Tập trung vào các điểm mạch như cổ tay, sau tai, cổ</li>
                        <li>Không chà xát sau khi xịt để tránh làm biến đổi hương thơm</li>
                        <li>Bảo quản nơi khô ráo, tránh ánh nắng trực tiếp</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="related-products mt-5">
            <h3>Sản phẩm liên quan</h3>
            <div id="related-products" class="row"></div>
        </div>
    </div>
</div>
<script>
    function getProductId() {
    // Lấy từ query string hoặc localStorage
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('id')) {
        return urlParams.get('id');
    }
    return localStorage.getItem('selectedProductId');
    }

    const productId = getProductId();
    if (!productId) {
    document.getElementById('productName').textContent = 'Không tìm thấy sản phẩm!';
    } else {
    fetch('/app/api/product-detail.php?id=' + productId)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                document.getElementById('productName').textContent = 'Không tìm thấy sản phẩm!';
                return;
            }
            const product = data.product;
            // Gán dữ liệu vào các phần tử sẵn có
            document.getElementById('productImage').src = '/app/' + product.image_urf;
            document.getElementById('productImage').alt = product.name;
            document.getElementById('productName').textContent = product.name;
            document.getElementById('productPrice').textContent = 'Giá: ' + Number(product.price).toLocaleString('vi-VN') + '₫';
            document.getElementById('productDescription').textContent = product.description || '';
            document.getElementById('add-to-cart').dataset.productId = product.id;
            document.getElementById('buy-now').dataset.productId = product.id;

            // Hiển thị sản phẩm liên quan
            const related = data.related;
            document.getElementById('related-products').innerHTML = related.map(rp => `
                <div class="col-md-3 product-col">
                    <div class="card product-card">
                        <div class="product-image">
                            <img src="/app/${rp.image_urf}" class="card-img-top" alt="${rp.name}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${rp.name}</h5>
                            <p class="price">${Number(rp.price).toLocaleString('vi-VN')}₫</p>
                            
                        </div>
                        <div class="d-flex " style="justify-content: space-between; padding: 6px;">
                            <button class="btn btn-primary add-to-cart" data-product-id="${rp.id}">Thêm vào giỏ</button>
                            <button class="btn btn-success buy-now" data-product-id="${rp.id}">Mua ngay</button>
                            </div>
                    </div>
                </div>
            `).join('');
        });
    }

</script>