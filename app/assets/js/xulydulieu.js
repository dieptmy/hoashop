$('.slide-product').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    nav: true,
    dots: false,
    responsive: {
        400: { items: 1 },
        700: { items: 2 },
        1000: { items: 5 }
    }
});

$('.slide-banner').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    autoplay: true,
    responsive: {
        0: { items: 1 }
    }
});



// $('#close-menu').click(function() {
//     $('.account').hide();
// });

// $('#show-menu').click(function() {
//     $('.account').show();
// });

// $('.product-image img').click(function() {
//     window.location.href = "product-detail.html";
// });

// $('#button-close, #btn-close').click(function() {
//     $('#box-inf').hide();
// });

// $('#filterBtn').click(function() {
//     window.location.href = "";
// });

const authUser = JSON.parse(localStorage.getItem('auth'));
let products = [];

fetch('/app/api/products.php')
    .then(response => response.json())
    .then(data => {
        products = data.data;
        renderProducts();
        renderAllProduct();
    })
    .catch(error => console.error('Error loading products:', error));

function renderProducts() {
    const productContainer = document.querySelector('.slide-product');
    if (!productContainer) return;

    // Xóa nội dung cũ trước khi render mới
    productContainer.innerHTML = '';

    products.slice(0, 6).forEach(product => {
        const productHTML = `
            <div class="item">
                <div class="description col-md-9 col-sm-7 col-lg-12 d-flex m-auto flex-column">
                   
                    <div style="cursor: pointer;" class="product-image">
                        <img src="/app/${product.image_urf}" alt="${product.name}">
                    </div>
                    <p class="name">${product.name}</p>
                    <p class="price">${formatCurrency(product.price)}</p>
                    <p class="brand">Thương hiệu: ${product.brand}</p>
                    <div class="btnbox">
                            <div class="button add-to-cart-bestseller" data-product-id="${product.id}">Thêm vào giỏ</div>
                        <div class="button btn-buy" data-product-id="${product.id}">Mua ngay</div>
                    </div>
                    
                </div>
            </div>
        `;
        productContainer.innerHTML += productHTML;
    });



    // Khởi tạo lại Owl Carousel
    if ($.fn.owlCarousel) {
        $('.slide-product').owlCarousel('destroy'); // Hủy carousel cũ
        $('.slide-product').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            nav: true,
            dots: false,
            responsive: {
                400: { items: 1 },
                700: { items: 2 },
                1000: { items: 5 }
            }
        });
    } else {
        console.error('Owl Carousel is not loaded');
    }

}

function renderAllProduct() {
    const allProductContainer = document.querySelector('.all-product');
    if(!allProductContainer) return;

    allProductContainer.innerHTML = '';

    products.slice(0, 10).forEach(product => {
        const allProductHTML = `
            <div class="item">
                <div class="description col-md-9 col-sm-7 col-lg-12 d-flex m-auto flex-column">
                   
                    <div style="cursor: pointer;" class="product-image">
                        <img src="/app/${product.image_urf}" alt="${product.name}">
                    </div>
                    <p class="name">${product.name}</p>
                    <p class="price">${formatCurrency(product.price)}</p>
                    <p class="brand">Thương hiệu: ${product.brand}</p>
                    <div class="btnbox">
                            <div class="button add-to-cart-bestseller" data-product-id="${product.id}">Thêm vào giỏ</div>
                        <div class="button btn-buy" data-product-id="${product.id}">Mua ngay</div>
                    </div>
                    
                </div>
            </div>
        `
        allProductContainer.innerHTML += allProductHTML;
    });

    if ($.fn.owlCarousel) {
        $('.slide-product').owlCarousel('destroy'); // Hủy carousel cũ
        $('.slide-product').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            nav: true,
            dots: false,
            responsive: {
                400: { items: 1 },
                700: { items: 2 },
                1000: { items: 5 }
            }
        });
    } else {
        console.error('Owl Carousel is not loaded');
    }

    document.getElementById('viewAllBtn').onclick = function() {
        window.location.href = 'allProduct-page1.html';
    };
}

// Hàm cập nhật hiển thị giá trong modal
function updateModalPrice(basePrice, volume, quantity) {
    const adjustedPrice = calculatePriceByVolume(basePrice, volume);
    const total = adjustedPrice * quantity;
    
    // Cập nhật hiển thị giá đơn vị
    const unitPriceElement = document.getElementById('modalUnitPrice');
    if (unitPriceElement) {
        unitPriceElement.textContent = formatCurrency(adjustedPrice);
    }
    
    // Cập nhật hiển thị tổng giá
    const totalPriceElement = document.getElementById('modalTotalPrice');
    if (totalPriceElement) {
        totalPriceElement.textContent = formatCurrency(total);
    }

    // Cập nhật hiển thị giá đơn vị
    const unitPriceElementBuyNow = document.getElementById('modalUnitPriceBuyNow');
    if (unitPriceElementBuyNow) {
        unitPriceElementBuyNow.textContent = formatCurrency(adjustedPrice);
    }
    
    // Cập nhật hiển thị tổng giá
    const totalPriceElementBuyNow = document.getElementById('modalTotalPriceBuyNow');
    if (totalPriceElementBuyNow) {
        totalPriceElementBuyNow.textContent = formatCurrency(total);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addToCartModal');
    const modalBuyNow = document.getElementById('buyNowModal');
    const closeModal = document.querySelector('.close-modal');
    const cancelBtn = document.querySelector('.cancel-btn');
    const overlay = document.querySelector('.overlay');
    const closeModalBuyNow = document.querySelector('.close-modal-buy-now');
    const cancelBtnBuyNow = document.querySelector('.cancel-btn-buy-now');
    const overlayBuyNow = document.querySelector('.overlay-buy-now');

    if(modalBuyNow) {
        modalBuyNow.style.display = 'none';
    }
    if(modal) {
    modal.style.display = 'none';
    }


    // Xử lý cho .description .add-to-cart-bestseller
    document.addEventListener('click', function(e) {
        const addToCartBtn = e.target.closest('.add-to-cart-bestseller');
        if (addToCartBtn && addToCartBtn.closest('.description')) {
            if (!authUser) {
                alert('Mời bạn đăng nhập hoặc đăng kí tài khoản để mua sản phẩm');
                return;
            }

            const productCard = addToCartBtn.closest('.description');
            if (!productCard) return;

            try {
                const productName = productCard.querySelector('.name')?.textContent || '';
                const productPrice = (productCard.querySelector('.price')?.textContent || '').replace(/,/g, '');
                const productImage = productCard.querySelector('img')?.src || '';
                const productId = addToCartBtn.dataset.productId;
                console.log('productPrice', productPrice);

                if (!productName || !productPrice || !productImage) {
                    console.error('Không thể lấy thông tin sản phẩm');
                    return;
                }

                // Lưu productId vào modal
                const modalContent = document.querySelector('.modal-content');
                modalContent.dataset.productId = productId;

                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';

                // Lưu giá gốc vào data attribute
                modalContent.dataset.basePrice = productPrice;

                document.getElementById('modalProductName').textContent = productName;
                document.getElementById('modalProductImage').src = productImage;

                // Reset selection
                document.querySelectorAll('.ml-option').forEach(btn => btn.classList.remove('selected'));
                document.querySelector('.ml-option[data-ml="100"]').classList.add('selected');
                document.querySelector('.quantity-input').value = 1;

                //Cập nhật giá ban đầu
                updateModalPrice(productPrice, 100, 1);
            } catch (error) {
                console.error('Lỗi khi lấy thông tin sản phẩm:', error);
            }
        }
    });

    // Xử lý cho .product-card .add-to-cart
    document.addEventListener('click', function(e) {
        const addToCartBtn = e.target.closest('.add-to-cart');
        if (addToCartBtn && addToCartBtn.closest('.product-card') && !addToCartBtn.closest('.description')) {
            if (!authUser) {
                alert('Mời bạn đăng nhập hoặc đăng kí tài khoản để mua sản phẩm');
                return;
            }

            const productCard = addToCartBtn.closest('.product-card');
            if (!productCard) return;

            try {
                const productName = productCard.querySelector('.card-title')?.textContent || '';
                const productPrice = productCard.querySelector('.price')?.textContent || '';
                const productImage = productCard.querySelector('img')?.src || '';
                const productId = addToCartBtn.dataset.productId;

                if (!productName || !productPrice || !productImage) {
                    console.error('Không thể lấy thông tin sản phẩm');
                    console.log({productName, productPrice, productImage, productId, productCard});
                    return;
                }

                // Lưu productId vào modal
                const modalContent = document.querySelector('.modal-content');
                modalContent.dataset.productId = productId;

                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';

                // Lưu giá gốc vào data attribute
                modalContent.dataset.basePrice = productPrice;

                document.getElementById('modalProductName').textContent = productName;
                document.getElementById('modalProductImage').src = productImage;

                // Lấy data-volume nếu có
                const productCol = productCard.closest('[data-volume]');
                const dataVolume = addToCartBtn.getAttribute('data-volume') || productCol?.dataset.volume;

                // Reset selection
                document.querySelectorAll('.ml-option').forEach(btn => btn.classList.remove('selected'));
                if (dataVolume) {
                    const mlBtn = document.querySelector(`.ml-option[data-ml="${dataVolume}"]`);
                    if (mlBtn) mlBtn.classList.add('selected');
                    updateModalPrice(productPrice, dataVolume, 1);                                                                          
                } else {
                    document.querySelector('.ml-option[data-ml="100"]').classList.add('selected');
                    updateModalPrice(productPrice, 100, 1);
                }
                document.querySelector('.quantity-input').value = 1;

                
            } catch (error) {
                console.error('Lỗi khi lấy thông tin sản phẩm:', error);
            }
        }
    });

    //
    document.addEventListener('click', function(e) {
        const addToCartBtn = e.target.closest('.add-to-cart');
        if (addToCartBtn && addToCartBtn.closest('.product-card-detail') && !addToCartBtn.closest('.description') && !addToCartBtn.closest('.product-card')) {
            if (!authUser) {
                alert('Mời bạn đăng nhập hoặc đăng kí tài khoản để mua sản phẩm');
                return;
            }

            const productCard = addToCartBtn.closest('.product-card-detail');
            if (!productCard) return;

            try {
                const productName = productCard.querySelector('#productName')?.textContent || '';
                const productPrice = productCard.querySelector('#productPrice')?.textContent || '';
                const productImage = productCard.querySelector('img')?.src || '';
                const productId = addToCartBtn.dataset.productId;

                if (!productName || !productPrice || !productImage) {
                    console.error('Không thể lấy thông tin sản phẩm');
                    console.log({productName, productPrice, productImage, productId, productCard});
                    return;
                }

                // Lưu productId vào modal
                const modalContent = document.querySelector('.modal-content');
                modalContent.dataset.productId = productId;

                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';

                // Lưu giá gốc vào data attribute
                modalContent.dataset.basePrice = productPrice;

                document.getElementById('modalProductName').textContent = productName;
                document.getElementById('modalProductImage').src = productImage;

                // Reset selection
                document.querySelectorAll('.ml-option').forEach(btn => btn.classList.remove('selected'));
                document.querySelector('.ml-option[data-ml="100"]').classList.add('selected');
                document.querySelector('.quantity-input').value = 1;

                //Cập nhật giá ban đầu
                updateModalPrice(productPrice, 100, 1);
            } catch (error) {
                console.error('Lỗi khi lấy thông tin sản phẩm:', error);
            }
        }
    });

    // Xử lý mua hàng 

    document.addEventListener('click', function(e) {
    const buyNowBtn = e.target.closest('.btn-buy');
    if (buyNowBtn && buyNowBtn.closest('.description') ) {
        if (!authUser) {
            alert('Mời bạn đăng nhập hoặc đăng kí tài khoản để mua sản phẩm');
            return;
        }

        const productCard = buyNowBtn.closest('.description');
        if (!productCard) return;

        try {
            const productName = productCard.querySelector('.name')?.textContent || '';
            const productPrice = productCard.querySelector('.price')?.textContent || '';
            const productImage = productCard.querySelector('img')?.src || '';
            const productId = buyNowBtn.dataset.productId;

            if (!productName || !productPrice || !productImage) {
                console.error('Không thể lấy thông tin sản phẩm');
                console.log({productName, productPrice, productImage, productId, productCard});
                return;
            }
            
            // Lưu productId vào modal
            const modalContentBuyNow = document.querySelector('.modal-content-buy-now');
            modalContentBuyNow.dataset.productId = productId;

            modalBuyNow.style.display = 'block';
            document.body.style.overflow = 'hidden';

            // Lưu giá gốc vào data attribute
            modalContentBuyNow.dataset.basePrice = productPrice;

            document.getElementById('modalProductNameBuyNow').textContent = productName;
            document.getElementById('modalProductImageBuyNow').src = productImage;

            // Reset selection
            document.querySelectorAll('.ml-option-buy-now').forEach(btn => btn.classList.remove('selected'));
            document.querySelector('.ml-option-buy-now[data-ml="100"]').classList.add('selected');
            document.querySelector('.quantity-input-buy-now').value = 1;

            //Cập nhật giá ban đầu
            updateModalPrice(productPrice, 100, 1);
        } catch (error) {
                console.error('Lỗi khi lấy thông tin sản phẩm:', error);
            }
        }
    });

    document.addEventListener('click', function(e) {
        const buyNowBtn = e.target.closest('.buy-now');
        if (buyNowBtn && buyNowBtn.closest('.product-card') && !buyNowBtn.closest('.description') && !buyNowBtn.closest('.product-card-detail')) {
            if (!authUser) {
                alert('Mời bạn đăng nhập hoặc đăng kí tài khoản để mua sản phẩm');
                return;
            }
    
            const productCard = buyNowBtn.closest('.product-card');
            if (!productCard) return;
    
            try {
                const productName = productCard.querySelector('.card-title')?.textContent || '';
                const productPrice = productCard.querySelector('.price')?.textContent || '';
                const productImage = productCard.querySelector('img')?.src || '';
                const productId = buyNowBtn.dataset.productId;
    
                if (!productName || !productPrice || !productImage) {
                    console.error('Không thể lấy thông tin sản phẩm');
                    console.log({productName, productPrice, productImage, productId, productCard});
                    return;
                }
                console.log({productName, productPrice, productImage, productId, productCard});
                // Lưu productId vào modal
                const modalContentBuyNow = document.querySelector('.modal-content-buy-now');

                if (!modalContentBuyNow) {
                    console.error("Không tìm thấy phần tử có class 'modal-content-buy-now'");
                    return;
                }
                modalContentBuyNow.dataset.productId = productId;

                
    
                modalBuyNow.style.display = 'block';
                document.body.style.overflow = 'hidden';
    
                // Lưu giá gốc vào data attribute
                modalContentBuyNow.dataset.basePrice = productPrice;
    
                document.getElementById('modalProductNameBuyNow').textContent = productName;
                document.getElementById('modalProductImageBuyNow').src = productImage;
    
                // Lấy data-volume nếu có
                const productCol = productCard.closest('[data-volume]');
                const dataVolume = buyNowBtn.getAttribute('data-volume') || productCol?.dataset.volume;

                // Reset selection
                document.querySelectorAll('.ml-option-buy-now').forEach(btn => btn.classList.remove('selected'));
                console.log('dataVolume', dataVolume);
                console.log('data-volume:', productCard.dataset.volume);

                if (dataVolume) {
                    const mlBtn = document.querySelector(`.ml-option-buy-now[data-ml="${dataVolume}"]`);
                    if (mlBtn) mlBtn.classList.add('selected');
                    updateModalPrice(productPrice, dataVolume, 1);
                    
                } else {
                    document.querySelector('.ml-option-buy-now[data-ml="100"]').classList.add('selected');
                    //Cập nhật giá ban đầu
                    updateModalPrice(productPrice, 100, 1);
                }
                document.querySelector('.quantity-input-buy-now').value = 1;
    
            } catch (error) {
                    console.error('Lỗi khi lấy thông tin sản phẩm:', error);
                }
            }
    });


    document.addEventListener('click', function(e) {
        const buyNowBtn = e.target.closest('.buy-now');
        if (buyNowBtn && buyNowBtn.closest('.product-card-detail') && !buyNowBtn.closest('.description') && !buyNowBtn.closest('.product-card')) {
            if (!authUser) {
                alert('Mời bạn đăng nhập hoặc đăng kí tài khoản để mua sản phẩm');
                return;
            }
    
            const productCard = buyNowBtn.closest('.product-card-detail');
            if (!productCard) return;
    
            try {
                const productName = productCard.querySelector('#productName')?.textContent || '';
                const productPrice = productCard.querySelector('#productPrice')?.textContent || '';
                const productImage = productCard.querySelector('img')?.src || '';
                const productId = buyNowBtn.dataset.productId;
    
                if (!productName || !productPrice || !productImage) {
                    console.error('Không thể lấy thông tin sản phẩm');
                    console.log({productName, productPrice, productImage, productId, productCard});
                    return;
                }
                console.log({productName, productPrice, productImage, productId, productCard});
                // Lưu productId vào modal
                const modalContentBuyNow = document.querySelector('.modal-content-buy-now');

                if (!modalContentBuyNow) {
                    console.error("Không tìm thấy phần tử có class 'modal-content-buy-now'");
                    return;
                }
                modalContentBuyNow.dataset.productId = productId;

                
    
                modalBuyNow.style.display = 'block';
                document.body.style.overflow = 'hidden';
    
                // Lưu giá gốc vào data attribute
                modalContentBuyNow.dataset.basePrice = productPrice;
    
                document.getElementById('modalProductNameBuyNow').textContent = productName;
                document.getElementById('modalProductImageBuyNow').src = productImage;
    
                // Reset selection
                document.querySelectorAll('.ml-option-buy-now').forEach(btn => btn.classList.remove('selected'));
                document.querySelector('.ml-option-buy-now[data-ml="100"]').classList.add('selected');
                document.querySelector('.quantity-input-buy-now').value = 1;
    
                //Cập nhật giá ban đầu
                updateModalPrice(productPrice, 100, 1);
            } catch (error) {
                    console.error('Lỗi khi lấy thông tin sản phẩm:', error);
                }
            }
    });


    // Xử lý đóng modal
    function closeModalHandler() {
        modal.style.display = 'none';
        modalBuyNow.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    closeModal?.addEventListener('click', closeModalHandler);
    cancelBtn?.addEventListener('click', closeModalHandler);
    overlay?.addEventListener('click', closeModalHandler);

    closeModalBuyNow?.addEventListener('click', closeModalHandler);
    cancelBtnBuyNow?.addEventListener('click', closeModalHandler);
    overlayBuyNow?.addEventListener('click', closeModalHandler);

    // Xử lý khi nhấn nút xác nhận
    const confirmBtn = document.querySelector('.confirm-btn');
    confirmBtn?.addEventListener('click', async function() {
        const productName = document.getElementById('modalProductName').textContent;
        const productImage = document.getElementById('modalProductImage').src;
        const selectedMl = document.querySelector('.ml-option.selected');
        const mlValue = selectedMl?.dataset.ml; 
        const quantity = parseInt(document.querySelector('.quantity-input').value);
        const basePrice = document.querySelector('.modal-content').dataset.basePrice;
        const volume = selectedMl ? parseInt(selectedMl.dataset.ml) : 100;

        // Lấy productId từ modal
        const productId = document.querySelector('.modal-content').dataset.productId;
        if (!productId) {
            alert('Không thể xác định sản phẩm');
            return;
        }

        // Chuyển đổi ml thành volume_id
        const volumeId = {
            '10': 1,
            '30': 2,
            '50': 3,
            '100': 4
        }[mlValue] || 4;

        console.log('Gửi lên API:', { product_id: productId, volume_id: volumeId });
        try {
            const response = await fetch('api/getVolumeProductId.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    product_id: productId,
                    volume_id: volumeId
                })
            });

            const text = await response.text();
            console.log('API trả về:', text);
            const data = JSON.parse(text);

            if (!data.success) {
                throw new Error(data.message);
            }
        
        const product = {
            name: productName,
            price: basePrice,
            image: productImage,
            ml: volume,
                quantity: quantity,
                volume_product_id: data.volume_product_id
        };

        addToCart(product);
        closeModalHandler();
        } catch (error) {
            console.error('Error getting volume product id:', error);
            alert('Có lỗi xảy ra: ' + error.message);
        }
    });

    const confirmBuyNowBtn = document.querySelector('.buy-now-btn');
    confirmBuyNowBtn?.addEventListener('click', async function() {
        const productName = document.getElementById('modalProductNameBuyNow').textContent;
        const productImage = document.getElementById('modalProductImageBuyNow').src;
        const selectedMl = document.querySelector('.ml-option-buy-now.selected');
        const mlValue = selectedMl?.dataset.ml; 
        const quantity = parseInt(document.querySelector('.quantity-input-buy-now').value);
        const basePrice = document.querySelector('.modal-content-buy-now').dataset.basePrice;
        const volume = selectedMl ? parseInt(selectedMl.dataset.ml) : 100;
        console.log('basePrice', basePrice);

        // Lấy productId từ modal
        const productId = document.querySelector('.modal-content-buy-now').dataset.productId;
        if (!productId) {
            alert('Không thể xác định sản phẩm');
            return;
        }

        // Chuyển đổi ml thành volume_id
        const volumeId = {
            '10': 1,
            '30': 2,
            '50': 3,
            '100': 4
        }[mlValue] || 4;

        console.log('Gửi lên API:', { product_id: productId, volume_id: volumeId });
        try {
            const response = await fetch('api/getVolumeProductId.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    product_id: productId,
                    volume_id: volumeId
                })
            });

            const text = await response.text();
            console.log('API trả về:', text);
            const data = JSON.parse(text);

            if (!data.success) {
                throw new Error(data.message);
            }

            const res = await fetch('api/product-detail.php?id=' + data.volume_product_id);
            const dataProduct = await res.json();
            const price = dataProduct.product.price;

            const product = {
                name: productName,
                price: price,
                image: productImage,
                ml: volume,
                quantity: quantity,
                volume_product_id: data.volume_product_id
            };
            const products = [];
            products.push(product);
            localStorage.setItem('productBuy', JSON.stringify(products));

            const auth = localStorage.getItem('auth');
            if (!auth) {
                alert('Vui lòng đăng nhập để mua hàng!');
                window.location.href = 'login.html';
                return;
            }
            const user = JSON.parse(auth);

            // Kiểm tra thông tin user
            if (user.fullname && user.address && user.district && user.city) {
                
                window.location.href = 'checkout.html';
            } else {
                // Hiện modal nhập thông tin    
                showUserInfoModal(async function(userInfo) {
                    // Gửi thông tin lên server (giả sử có api/updateUser.php)
                    const response = await fetch('api/updateUser.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            user_id: user.id || user.user_id,
                            ...userInfo
                        })
                    });
                    const data = await response.json();
                    if (data.success) {
                        // Cập nhật localStorage
                        Object.assign(user, userInfo);
                        localStorage.setItem('auth', JSON.stringify(user));
                        // Lưu sản phẩm chọn mua vào localStorage
                        // const productCard = buyNowBtn.closest('.description');
                        // if (!productCard) return;
                        // const product = localStorage.getItem('product-buy');
                        // const productVolumeId = JSON.parse(product).volume_product_id;
                        // localStorage.setItem('checkoutProductVolumeId', productVolumeId);
                        // const quantity = JSON.parse(product).quantity;
                        // localStorage.setItem('checkoutProductQuantity', quantity);
                        window.location.href = 'checkout.html';
                    } else {
                        alert('Cập nhật thông tin thất bại!');
                    }
                });
            }


            closeModalHandler();
        } catch (error) {
            console.error('Error getting volume product id:', error);
            alert('Có lỗi xảy ra: ' + error.message);
        }
    });

    // Xử lý khi thay đổi ml
    document.querySelectorAll('.ml-option').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.ml-option').forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
            
            // Cập nhật giá của modal thêm vào giỏ hàng
            const modalContent = document.querySelector('.modal-content');
            const basePrice = modalContent.dataset.basePrice;
            const volume = parseInt(this.dataset.ml);
            const quantity = parseInt(document.querySelector('.quantity-input').value);
            
            updateModalPrice(basePrice, volume, quantity);

        });
    });

    document.querySelectorAll('.ml-option-buy-now').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.ml-option-buy-now').forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
            
            // Cập nhật giá của modal thêm vào giỏ hàng
            const modalContentBuyNow = document.querySelector('.modal-content-buy-now');
            const basePriceBuyNow = modalContentBuyNow.dataset.basePrice;
            const volumeBuyNow = parseInt(this.dataset.ml);
            const quantityBuyNow = parseInt(document.querySelector('.quantity-input-buy-now').value);
            
            updateModalPrice(basePriceBuyNow, volumeBuyNow, quantityBuyNow);

        });
    });

    // Xử lý khi thay đổi số lượng
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value) || 1;
            
            if (this.classList.contains('minus') && value > 1) {
                value--;
            } else if (this.classList.contains('plus') && value < 10) {
                value++;
            }
            
            input.value = value;
            
            const modalContent = document.querySelector('.modal-content');
            const basePrice = modalContent.dataset.basePrice;
            const selectedMl = document.querySelector('.ml-option.selected');
            const volume = selectedMl ? parseInt(selectedMl.dataset.ml) : 100;
            
            updateModalPrice(basePrice, volume, value);
        });
    });

    document.querySelectorAll('.quantity-btn-buy-now').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input-buy-now');
            let value = parseInt(input.value) || 1; 
    
            if (this.classList.contains('minus') && value > 1) {
                value--;
            } else if (this.classList.contains('plus') && value < 10) {
                value++;
            }
            
            input.value = value;

            const modalContentBuyNow = document.querySelector('.modal-content-buy-now');
            const basePriceBuyNow = modalContentBuyNow.dataset.basePrice;
            const selectedMlBuyNow = document.querySelector('.ml-option-buy-now.selected');
            const volumeBuyNow = selectedMlBuyNow ? parseInt(selectedMlBuyNow.dataset.ml) : 100;    
            
            updateModalPrice(basePriceBuyNow, volumeBuyNow, value);
        });
    });

    // Xử lý nhập số lượng trực tiếp
    document.querySelector('.quantity-input')?.addEventListener('change', function() {
        let value = parseInt(this.value) || 1;
        if (value < 1) value = 1;
        if (value > 10) value = 10;
        this.value = value;

        const modalContent = document.querySelector('.modal-content');
        const basePrice = modalContent.dataset.basePrice;
        const selectedMl = document.querySelector('.ml-option.selected');
        const volume = selectedMl ? parseInt(selectedMl.dataset.ml) : 100;
        
        updateModalPrice(basePrice, volume, value);
    });

    document.querySelector('.quantity-input-buy-now')?.addEventListener('change', function() {
        let value = parseInt(this.value) || 1;
        if (value < 1) value = 1;
        if (value > 10) value = 10;
        this.value = value;

        const modalContentBuyNow = document.querySelector('.modal-content-buy-now');
        const basePriceBuyNow = modalContentBuyNow.dataset.basePrice;
        const selectedMlBuyNow = document.querySelector('.ml-option-buy-now.selected');
        const volumeBuyNow = selectedMlBuyNow ? parseInt(selectedMlBuyNow.dataset.ml) : 100;
        
        updateModalPrice(basePriceBuyNow, volumeBuyNow, value);
    });
});



// Ấn vào nút accountBtn thì hiển thị boxbox
const accountBtn = document.getElementById('accountBtn');
if(accountBtn) {
    console.log('accountBtn', accountBtn);
    accountBtn.addEventListener('click', function() {
        if (authUser) { 
            const accountBoxHad = document.getElementById('accountBox-had');
        if (accountBoxHad) {
            accountBoxHad.style.display = accountBoxHad.style.display === 'none' ? 'block' : 'none';
        }
    } else {
        const accountBoxNo = document.getElementById('accountBox-no');
        if (accountBoxNo) {
            accountBoxNo.style.display = accountBoxNo.style.display === 'none' ? 'block' : 'none';
        }
    }
    });
}

// Ẩn box account khi click ra ngoài
document.addEventListener('click', function(e) {
    const accountBox = document.getElementById('accountBox-had');
    const accountBoxNo = document.getElementById('accountBox-no');
    if (!accountBox.contains(e.target) && e.target.id !== 'accountBtn') {
        accountBox.style.display = 'none';
        accountBoxNo.style.display = 'none';
    }
});


// const menuBtn = document.getElementById('show-menu');
// if(menuBtn) {
//     menuBtn.addEventListener('click', function() {
//         const accountBox = document.querySelector('.account');
//         accountBox.style.display = accountBox.style.display === 'none' ? 'block' : 'none';
//     })
// }

const logoutBtn = document.getElementById('logout');
if(logoutBtn) {
    console.log('logoutBtn', logoutBtn);
    logoutBtn.addEventListener('click', function() {
        localStorage.removeItem('auth');
        window.location.reload();
    });
}

// Thêm hàm để lấy cart key của user cụ thể
function getUserCartKey(username) {
    return `cart_${username}`;
}

// Hàm format số tiền
function formatCurrency(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'đ';
}

// Hàm tính giá dựa trên ml
function calculatePriceByVolume(basePrice, volume) {
    // Chuyển giá từ string sang number nếu cần
    const price = typeof basePrice === 'string' ? 
        parseFloat(basePrice.replace(/[^\d]/g, '')) : 
        parseFloat(basePrice);

    // Tính discount dựa trên ml
    let discount = 0;
    switch (volume) {
        case 10:
            discount = 0.3; // giảm 30%
            break;
        case 30:
            discount = 0.2; // giảm 20%
            break;
        case 50:
            discount = 0.1; // giảm 10%
            break;
        default:
            discount = 0; // 100ml - không giảm
    }

   
    const finalPrice = price * (1 - discount);
    return Math.round(finalPrice); 
}

// Hàm đồng bộ giỏ hàng khi đăng nhập
async function syncUserCart(username) {
    try {
        localStorage.removeItem('cart');
        const userCartKey = getUserCartKey(username);
        let cartData = { items: [], total: "0" };

        try {
            const response = await fetch('/app/api/cart.php');
            if (response.ok) {
                const data = await response.json();
                if (data.success && Array.isArray(data.data)) {
                    const items = data.data;
                    let total = 0;
                    items.forEach(item => {
                        if (item.price && item.quantity) {
                            total += parseFloat(item.price) * parseInt(item.quantity);
                        }
                    });
                    cartData = { items, total: formatCurrency(total) };
                }
            }
        } catch (error) {
            // Nếu không lấy được từ server, thử lấy từ localStorage
            const localCart = localStorage.getItem(userCartKey);
            if (localCart) {
                try {
                    cartData = JSON.parse(localCart);
                    // Format total if exists
                    if (cartData.total) {
                        const totalNum = parseFloat(cartData.total.replace(/[^\d]/g, ''));
                        cartData.total = formatCurrency(totalNum);
                    }
                } catch (e) {
                    console.error('Error parsing local cart:', e);
                }
            }
        }

        localStorage.setItem(userCartKey, JSON.stringify(cartData));
        return cartData;
    } catch (error) {
        console.error('Error syncing cart:', error);
        return;
    }
}

// Cập nhật lại hàm addToCart để sử dụng cart key riêng của user
async function addToCart(product) {
    try {
         // Kiểm tra đăng nhập
        const auth = localStorage.getItem('auth');
        if (!auth) {
            alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
            window.location.href = 'login.html';
            return;
        }

        const userData = JSON.parse(auth);
        if (!userData || !userData.username) {
            alert('Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại');
            localStorage.removeItem('auth');
            window.location.href = 'login.html';
            return;
        }

        const userCartKey = getUserCartKey(userData.username);
        let cart = localStorage.getItem(userCartKey);
        let cartData;
        try {
            cartData = cart ? JSON.parse(cart) : { items: [], total: "0" };
            if (!cartData.items || !Array.isArray(cartData.items)) {
                cartData = { items: [], total: "0" };
            }
        } catch (e) {
            cartData = { items: [], total: "0" };
        }

        // Kiểm tra dữ liệu sản phẩm
        if (!product || !product.name || !product.price) {
            throw new Error('Invalid product data');
        }

        // Tính giá dựa trên ml đã chọn
        const adjustedPrice = calculatePriceByVolume(product.price, product.ml);
        console.log('adjustedPrice', adjustedPrice);

        // Tìm sản phẩm trong giỏ hàng
        const existingItemIndex = cartData.items.findIndex(item => 
            item.name === product.name && item.volume === product.ml
        );

        // Cập nhật số lượng hoặc thêm mới
        if (existingItemIndex !== -1) {
            const newQuantity = cartData.items[existingItemIndex].quantity + (product.quantity || 1);
            if (newQuantity <= 10) {
                cartData.items[existingItemIndex].quantity = newQuantity;
            } else {
                alert('Số lượng sản phẩm đã đạt tối đa (10)');
                return;
            }
        } else {
            cartData.items.push({
                name: product.name,
                price: formatCurrency(adjustedPrice),
                image: product.image,
                quantity: product.quantity || 1,
                volume: product.ml,
                originalPrice: product.price
            });
        }

        // Tính tổng tiền
        const total = cartData.items.reduce((sum, item) => {
            const itemPrice = typeof item.price === 'string' ? 
                parseFloat(item.price.replace(/[^\d]/g, '')) : 
                parseFloat(item.price);
            return sum + (itemPrice * item.quantity);
        }, 0);
        
        cartData.total = formatCurrency(total);
        localStorage.setItem(userCartKey, JSON.stringify(cartData));

        // Gửi lên server
        const serverData = {
            user_id: userData.user_id,
            volume_product_id: product.volume_product_id,
            quantity: product.quantity
        };
        console.log('Gửi lên updateCart:', serverData);

        try {
            const updateResponse = await fetch('api/updateCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(serverData)
            });

            if (!updateResponse.ok) {
                throw new Error('Failed to update cart on server');
            }

            alert('Đã thêm vào giỏ hàng thành công');
        } catch (error) {
            alert('Đã thêm vào giỏ hàng (lưu cục bộ)');
        }

    } catch (error) {
        alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
    }
}

// Thêm xử lý đồng bộ giỏ hàng khi đăng nhập thành công
document.addEventListener('DOMContentLoaded', async function() {
    const auth = localStorage.getItem('auth');
    if (auth) {
        try {
            const userData = JSON.parse(auth);
            if (userData && userData.username) {
                await syncUserCart(userData.username);
            }
        } catch (error) {
            console.error('Error syncing cart on load:', error);
        }
    }
});

// Cập nhật style cho modal
const styleSheet = document.createElement('style');
styleSheet.textContent = ``;
document.head.appendChild(styleSheet);



// Hàm hiện modal nhập thông tin user 
function showUserInfoModal(onSubmit) {
    let modalUserInfo = document.getElementById('userInfoModal');
    if (!modalUserInfo) {
        modalUserInfo = document.createElement('div');
        modalUserInfo.id = 'userInfoModal';
        modalUserInfo.innerHTML = `
            <div class="modal" style="display:block;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);">
                <div class="modal-content" style="background:#fff;max-width:400px;margin:10vh auto;padding:24px;position:relative;">
                    <h3 style="font-size: 20px20px">Nhập thông tin nhận hàng</h3>
                    <label style="font-size: 1.4rem;">Họ tên: <input style="margin: 10px 0;height: 30px;font-size: 1.4rem;" type="text" id="modalFullname" class="form-control"></label><br>
                    <label style="font-size: 1.4rem;">Số điện thoại: <input style="margin: 10px 0;height: 30px;font-size: 1.4rem;" type="text" id="modalPhone" class="form-control"></label><br>
                    <label style="font-size: 1.4rem;">Địa chỉ: <input style="margin: 10px 0;height: 30px;font-size: 1.4rem;" type="text" id="modalAddress" class="form-control"></label><br>
                    <label style="font-size: 1.4rem;">Thành phố:
                        <select style="margin: 10px 0;height: 30px;font-size: 1.4rem;" id="modalCity" class="form-control">
                            <option value="">Chọn thành phố</option>
                        </select>
                    </label><br>
                    <label style="font-size: 1.4rem;">Quận/Huyện:
                        <select style="margin: 10px 0;height: 30px;font-size: 1.4rem;" id="modalDistrict" class="form-control">
                            <option value="">Chọn quận/huyện</option>
                        </select>
                    </label><br>
                    <div style="margin-top:12px; font-size: 1.4rem; display: flex; justify-content: space-between;">
                        <button style="font-size: 1.4rem;" id="modalUserInfoCancel" class="btn btn-outline-secondary">Hủy</button>
                        <button style="font-size: 1.4rem;" id="modalUserInfoSubmit" class="btn btn-outline-danger">Lưu & Tiếp tục</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modalUserInfo);
    }
    modalUserInfo.style.display = 'block';

    // Lấy thông tin user nếu có
    const auth = JSON.parse(localStorage.getItem('auth') || '{}');

    // Reset các trường
    document.getElementById('modalFullname').value = auth.fullname || '';
    document.getElementById('modalPhone').value = auth.number || '';
    document.getElementById('modalAddress').value = auth.address || '';
    const modalCity = document.getElementById('modalCity');
    const modalDistrict = document.getElementById('modalDistrict');
    modalCity.innerHTML = '<option value="">Chọn thành phố</option>';
    modalDistrict.innerHTML = '<option value="">Chọn quận/huyện</option>';

    // Load danh sách thành phố
    fetch('api/getCities.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                data.data.forEach(city => {
                    const opt = document.createElement('option');
                    opt.value = city.id;
                    opt.textContent = city.name;
                    modalCity.appendChild(opt);
                });
                // Nếu user đã có city, set value và load quận/huyện
                if (auth.city) {
                    // Tìm id của city theo tên (nếu lưu city là tên)
                    let cityId = '';
                    for (const city of data.data) {
                        if (city.name === auth.city || city.id == auth.city) {
                            cityId = city.id;
                            break;
                        }
                    }
                    if (cityId) {
                        modalCity.value = cityId;
                        loadDistrictsForModal(cityId, auth.district);
                    }
                }
            }
        });

    // Khi chọn thành phố, load quận/huyện
    modalCity.onchange = function() {
        const cityId = this.value;
        loadDistrictsForModal(cityId, '');
    };

    function loadDistrictsForModal(cityId, selectedDistrict = '') {
        modalDistrict.innerHTML = '<option value="">Chọn quận/huyện</option>';
        if (!cityId) return;
        fetch('api/getDistricts.php?city_id=' + cityId)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    data.data.forEach(district => {
                        const opt = document.createElement('option');
                        opt.value = district.id;
                        opt.textContent = district.name;
                        if (district.name === selectedDistrict || district.id == selectedDistrict) opt.selected = true;
                        modalDistrict.appendChild(opt);
                    });
                }
            });
    }

    // Xử lý nút Lưu & Tiếp tục
    document.getElementById('modalUserInfoSubmit').onclick = function() {
        const fullname = document.getElementById('modalFullname').value.trim();
        const phone = document.getElementById('modalPhone').value.trim();
        const address = document.getElementById('modalAddress').value.trim();
        const cityId = modalCity.value;
        const city = modalCity.options[modalCity.selectedIndex]?.text || '';
        const districtId = modalDistrict.value;
        const district = modalDistrict.options[modalDistrict.selectedIndex]?.text || '';
        if (!fullname || !phone || !address || !cityId || !districtId) {
            alert('Vui lòng nhập đầy đủ thông tin!');
            return;
        }
        modalUserInfo.style.display = 'none';
        onSubmit({ fullname, number: phone, address, city, cityId, district, districtId });
    };

    // Xử lý nút Hủy
    document.getElementById('modalUserInfoCancel').onclick = function() {
        modalUserInfo.style.display = 'none';
    };
}



document.getElementById('show-menu').onclick = function(e) {
    e.stopPropagation();
    var accountBox = document.querySelector('.account-user.collapse-box');
    if (accountBox) {
        accountBox.classList.toggle('show-mobile-menu');
    }
    // Hiện overlay nếu có
    var overlay = document.querySelector('.account .overlay');
    if (overlay) overlay.style.display = accountBox.classList.contains('show-mobile-menu') ? 'block' : 'none';
};

// Ẩn menu khi click ra ngoài hoặc click nút đóng
document.addEventListener('click', function(e) {
    var accountBox = document.querySelector('.account-user.collapse-box');
    var overlay = document.querySelector('.account .overlay');
    if (accountBox && accountBox.classList.contains('show-mobile-menu')) {
        if (!accountBox.contains(e.target) && e.target.id !== 'show-menu') {
            accountBox.classList.remove('show-mobile-menu');
            if (overlay) overlay.style.display = 'none';
        }
    }
});
document.getElementById('close-menu').onclick = function() {
    var accountBox = document.querySelector('.account-user.collapse-box');
    var overlay = document.querySelector('.account .overlay');
    if (accountBox) accountBox.classList.remove('show-mobile-menu');
    if (overlay) overlay.style.display = 'none';
};

// Khởi tạo dropdown cho menu mobile nếu không nằm trong navbar
document.querySelectorAll('.account-user.collapse-box .dropdown-toggle').forEach(function(toggle) {
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const menu = this.nextElementSibling;
        if (menu && menu.classList.contains('dropdown-menu')) {
            menu.classList.toggle('show');
        }
    });
});

// Ẩn dropdown khi click ra ngoài
document.addEventListener('click', function(e) {
    document.querySelectorAll('.account-user.collapse-box .dropdown-menu.show').forEach(function(menu) {
        if (!menu.previousElementSibling.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('show');
        }
    });
});