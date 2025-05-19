// Hàm format số tiền
function formatCurrency(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "đ";
}

// Hàm parse số tiền từ chuỗi
function parseCurrency(str) {
    return parseInt(str.replace(/\D/g, ""));
}



// Hàm lấy thông tin user đang đăng nhập
function getCurrentUser() {
    return localStorage.getItem('currentUser') || null;
}

// Hàm lấy key giỏ hàng của user
function getCartKey(username) {
    return `cart_${username}`;
}

// Lấy giỏ hàng của user hiện tại từ database qua API
async function getCurrentUserCart() {
    try {
        const username = getCurrentUsername();
        if (!username) {
            console.log('No user_id found');
            return { items: [], total: "0" };
        }

        // Gọi API để lấy giỏ hàng từ database
        const response = await fetch('/app/api/cart.php');
        if (!response.ok) throw new Error('Failed to fetch cart from server');
        const data = await response.json();

        

        if (data.success && Array.isArray(data.data)) {
            const items = data.data.map(item => ({
                ...item,
                price: parseInt(item.price), 
                quantity: parseInt(item.quantity)
            }));
            const total = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            return { items, total: formatCurrency(total) };
        } else {
            return { items: [], total: "0" };
        }
    } catch (error) {
        console.error('Error getting cart from server:', error);
        return { items: [], total: "0" };
    }
}

// Hàm cập nhật giỏ hàng
async function updateCartInFile(cartData) {
    try {
        const auth = localStorage.getItem('auth');
        if (!auth) {
            console.error('No auth data found');
            return;
        }

        const userData = JSON.parse(auth);
        if (!userData || !userData.username) {
            console.error('Invalid user data');
            return;
        }

        const userCartKey = `cart_${userData.username}`;
        localStorage.setItem(userCartKey, JSON.stringify(cartData));
        console.log('Cart updated in localStorage');
    } catch (error) {
        console.error('Error updating cart:', error);
    }
}

// Hàm cập nhật tổng tiền
async function updateTotal() {
    try {
        const cart = await getCurrentUserCart();
        if (!cart || !Array.isArray(cart.items)) {
            document.getElementById('subtotal').textContent = formatCurrency(0);
            document.getElementById('total').textContent = formatCurrency(50000);
            return;
        }

        const subtotal = cart.items.reduce((total, item, index) => {
            const checkbox = document.querySelectorAll('.item-checkbox')[index];
            if (checkbox && checkbox.checked) {
                const price = item.price;
                const quantity = item.quantity || 1;
                return total + (price * quantity);
            }
            return total;
        }, 0);

        // const shippingFee = subtotal > 0 ? 50000 : 0;
        const total = subtotal ;

        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('total').textContent = formatCurrency(total);
    } catch (error) {
        console.error('Error updating total:', error);
        document.getElementById('subtotal').textContent = formatCurrency(0);
        document.getElementById('total').textContent = formatCurrency(50000);
    }
}

// Hàm render sản phẩm trong giỏ hàng



document.addEventListener('DOMContentLoaded', async function() {
    renderCart();
});

async function renderCart() {
    const cartContainer = document.getElementById('cartItemsList');
    if (!cartContainer) {
        console.error('Cart container not found');
        return;
    }
    try {

        const cart = await getCurrentUserCart();
        if (!cart || !Array.isArray(cart.items) || cart.items.length === 0) {
            cartContainer.innerHTML = '<div class="empty-cart">Giỏ hàng của bạn đang trống</div>';
            updateTotal();
            return;
        }

        cartContainer.innerHTML = '';
        cart.items.forEach((item, index) => {
            if (!item || !item.name || !item.price) {
                console.error('Invalid item data:', item);
                return;
            }

            const image = item.image_urf || item.image || 'assets/images/default-product.jpg';
            const volume = item.volume || item.value || '';
            const quantity = item.quantity || 1;

            const cartItemHTML = `
                <div class="cart-item">
                    <input type="checkbox" class="item-checkbox" data-index="${index}" onchange="updateTotal()">
                    <div class="item-image">
                        <img src="/app/${image}" alt="${item.name}" onerror="this.src='/app/assets/images/default-product.jpg'">
                    </div>
                    <div class="item-details">
                        <div class="item-name">${item.name}</div>
                        <div class="item-volume">${volume} ml</div>
                        <div class="item-price">${formatCurrency(item.price)}</div>
                        <div class="item-quantity">
                            <button class="quantity-btn minus" onclick="updateQuantity(${item.volume_product_id}, ${quantity}, -1)">-</button>
                            <input type="number" class="quantity-input" value="${quantity}" min="1" max="10" data-volume-product-id="${item.volume_product_id}" onchange="updateQuantity(${item.volume_product_id}, ${quantity}, 0)">
                            <button class="quantity-btn plus" onclick="updateQuantity(${item.volume_product_id}, ${quantity}, 1)">+</button>
                            <span class="item-remove" onclick="removeItem(${item.volume_product_id})">
                                <i class="fas fa-trash"></i>
                            </span>
                        </div>
                    </div>
                </div>
            `;
            cartContainer.innerHTML += cartItemHTML;
        });

        updateTotal();
        window.cartData = cart;
    } catch (error) {
        console.error('Error rendering cart:', error);
        const cartContainer = document.getElementById('cartItemsList');
        if (cartContainer) {
            cartContainer.innerHTML = '<div class="error-message">Có lỗi xảy ra khi tải giỏ hàng</div>';
        }
    }
}

// Hàm cập nhật số lượng sản phẩm (gọi API để cập nhật DB)
async function updateQuantity(volume_product_id, currentQuantity, change) {
    const username = getCurrentUsername();
    const user_id = getCurrentUserId();
    if (!username) {
        alert('Vui lòng đăng nhập để thực hiện chức năng này');
        return;
    }

    let newValue = currentQuantity + change;
    if (newValue < 1) newValue = 1;
    if (newValue > 10) newValue = 10;

    try {
        // Gửi cập nhật lên server
        await fetch('/app/api/updateCart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                user_id: user_id,
                volume_product_id: volume_product_id,
                quantity: change
            })
        });

        renderCart();
    } catch (error) {
        console.error('Error updating quantity:', error);
    }
}





// Hàm xóa sản phẩm 
async function removeItem(volume_product_id) {
    const username = getCurrentUsername();
    const user_id = getCurrentUserId();
    if (!username) {
        alert('Vui lòng đăng nhập để thực hiện chức năng này');
        window.location.href = '/index.php/login';
        return;
    }

    try {
        // Gửi yêu cầu xóa lên server (quantity = 0)
        await fetch('/app/api/updateCart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                user_id: user_id,
                volume_product_id: volume_product_id,
                action: 'delete'
            })
        });

        renderCart();
    } catch (error) {
        console.error('Error removing item:', error);
    }
}

// Hàm thêm sản phẩm vào giỏ hàng 
async function addToCart(product) {
    try {
        const username = getCurrentUsername();
        if (!username) {
            alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
            return;
        }

        // Gửi cập nhật lên server
        await fetch('/app/api/updateCart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                user_id: user_id,
                volume_product_id: product.volume_product_id,
                quantity: 1
            })
        });

        renderCart();
        alert('Đã thêm sản phẩm vào giỏ hàng');
    } catch (error) {
        console.error('Error adding to cart:', error);
        alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
    }
}

// // Xóa cart trong localStorage khi load trang và render cart
// document.addEventListener('DOMContentLoaded', () => {
//     renderCart();
// }); 

function getCurrentUsername() {
    const auth = localStorage.getItem('auth');
    if (!auth) return null;
    const user = JSON.parse(auth);
    return user.username || null;
}

function getCurrentUserId() {
    const auth = localStorage.getItem('auth');
    if (!auth) return null;
    const user = JSON.parse(auth);
    return user.user_id || null;
}

//Xử lý nút checkout
const btnCheckout = document.querySelector('.btn-checkout');
if(btnCheckout) {
    console.log( " có btnCheckout");
    btnCheckout.addEventListener('click', function() {
        // 1. Lấy các sản phẩm được chọn
        const checkedItems = [];
        document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
            const index = cb.dataset.index;
            if (window.cartData && window.cartData.items && window.cartData.items[index]) {
                checkedItems.push(window.cartData.items[index]);
            }
        });

        if (checkedItems.length === 0) {
            alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán!');
            return;
        }
        const productBuy = JSON.parse(localStorage.getItem('productBuy'));
        if(productBuy) {
            localStorage.removeItem('productBuy');
        }
        // 2. Lưu vào localStorage
        localStorage.setItem('productBuy', JSON.stringify(checkedItems));

        // 3. Kiểm tra thông tin user
        const auth = JSON.parse(localStorage.getItem('auth') || '{}');
        if (auth.fullname && auth.address && auth.district && auth.city && auth.number) {
            window.location.href = '/index.php/checkout';
        } else {
            showUserInfoModal(function(userInfo) {
                fetch('/app/api/updateUser.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        user_id: auth.id || auth.user_id,
                        ...userInfo
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Object.assign(auth, userInfo);
                        localStorage.setItem('auth', JSON.stringify(auth));
                        window.location.href = '/index.php/checkout';
                    } else {
                        alert('Cập nhật thông tin thất bại!');
                    }
                });
            });
        }               
    });
}