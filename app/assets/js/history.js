document.addEventListener('DOMContentLoaded', function() {
    loadOrders();
});

async function loadOrders() {
    try {
        const auth = JSON.parse(localStorage.getItem('auth') || '{}');
        if (!auth.user_id) {
            document.getElementById('orderList').innerHTML = '<div class="alert alert-warning">Vui lòng đăng nhập để xem lịch sử đơn hàng</div>';
            return;
        }

        const response = await fetch(`/app/api/getOrders.php?user_id=${auth.user_id}`);
        // const data = await response.json();
        const text = await response.text();
        console.log("raw response: ", text);
        const data = JSON.parse(text);
        console.log("parsed response: ", data);

        if (!data.success) {
            throw new Error(data.message || 'Có lỗi xảy ra');
        }

        if (data.orders.length === 0) {
            console.log('sdfsfsdf'
            )
            document.getElementById('orderList').innerHTML = '<div class="alert alert-info">Bạn chưa có đơn hàng nào</div>';
            return;
        }

        let html = '';
        data.orders.forEach(order => {
            const firstItem = order.items[0];
            const hasMoreItems = order.items.length > 1;

            const orderStatus = order.status === 'delivered' ? 'Đã giao hàng thành công' : order.status;
            
            html += `
                <div class="order-card-history">
                    <div class="order-header-history">
                        <div style="font-size:18px" class="order-id-history">Đơn hàng #${order.id}</div>
                        <div style="color: #007bff" class="order-status-history status-${orderStatus.toLowerCase()}">${orderStatus}</div>
                    </div>
                    <div class="product-info-history">
                        <div class="product-image-history">
                            <img src="${firstItem.product_image}" alt="${firstItem.product_name}">
                        </div>
                        <div class="product-details-history">
                            <div class="text-start">
                            
                                <div style="font-size:16px" class="product-name-history">${firstItem.product_name}</div>
                                <div style="font-size:16px" class="product-brand-history">${firstItem.brand}</div>
                                <div style="font-size:16px" class="product-volume-history">${firstItem.volume_name}ml</div>
                            </div>
                            <div class="text-end">
                                <div style="font-size:16px" class="product-price-history">${Number(firstItem.price).toLocaleString('vi-VN')}đ x ${firstItem.quantity}</div>
                            </div>
                        </div>
                    </div>
                    ${hasMoreItems ? `
                        <div class="text-end-add" style="display: flex;margin: auto; padding-bottom: 12px;">
                            <button style="color: #007bff" class="view-more-btn-history" onclick="toggleAdditionalItems(${order.id})">
                                Xem thêm ${order.items.length - 1} sản phẩm
                            </button>
                        </div>
                        <div class="additional-items-history" id="additional-items-${order.id}">
                            ${order.items.slice(1).map(item => `
                                <div class="additional-item-history">
                                    <div class="product-image-history">
                                        <img src="${item.product_image}" alt="${item.product_name}">
                                    </div>
                                    <div class="product-details-history">
                                        <div class="text-start">
                            
                                            <div style="font-size:16px" class="product-name-history">${item.product_name}</div>
                                            <div style="font-size:16px" class="product-brand-history">${item.brand}</div>
                                            <div style="font-size:16px" class="product-volume-history">${item.volume_name}ml</div>
                                        </div>
                                        <div class="text-end">
                                            <div style="font-size:16px" class="product-price-history">${Number(item.price).toLocaleString('vi-VN')}đ x ${item.quantity}</div>
                                        </div>
                                    </div>
                            </div>
                            `).join('')}
                        </div>
                    ` : ''}
                    <div class="order-footer-history" style="    order: 4;border-top: 1px solid #eee;">
                        <div class="order-total-history " style="font-size:18px; font-weight: 600;text-align: right; padding-top: 10px;">
                            <span>Thành tiền:</span>
                            <span style="color: #e94560">${Number(order.total_price).toLocaleString('vi-VN')}đ</span>
                        </div>
                        
                    </div>.

                </div>
            `;
        });

        document.getElementById('orderList').innerHTML = html;

    } catch (error) {
        console.error('Error loading orders:', error);
        document.getElementById('orderList').innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra khi tải lịch sử đơn hàng</div>';
    }
}

function toggleAdditionalItems(orderId) {
    const additionalItems = document.getElementById(`additional-items-${orderId}`);
    const button = additionalItems.previousElementSibling.querySelector('.view-more-btn-history');
    
    if (additionalItems.classList.contains('show')) {
        additionalItems.classList.remove('show');
        button.textContent = `Xem thêm ${additionalItems.children.length} sản phẩm`;
    } else {
        additionalItems.classList.add('show');
        button.textContent = 'Ẩn bớt';
        document.querySelector('.text-end-add').style.order = '3';
    }
}
