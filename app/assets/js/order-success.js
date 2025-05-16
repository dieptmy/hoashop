alert('Bạn đã đặt hàng thành công!');

    // Lấy order_id từ query string
    function getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    const orderId = getQueryParam('order_id');
    console.log('orderId', orderId);
    if (!orderId) {
        document.body.innerHTML = '<div class="container mt-5"><div class="alert alert-danger">Không tìm thấy đơn hàng!</div></div>';
    } else {
        fetch('api/getOrderDetail.php?order_id=' + orderId)
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    document.body.innerHTML = '<div class="container mt-5"><div class="alert alert-danger">Không tìm thấy đơn hàng!</div></div>';
                    return;
                }
                if (!data.order || !data.user || !data.items) {
                    document.body.innerHTML = '<div class="container mt-5"><div class="alert alert-danger">Dữ liệu đơn hàng không đầy đủ!</div></div>';
                    return;
                }
                
                
                console.log('data', data.order);
                console.log('data', data.user);
                console.log('data', data.items);
                // Thông tin đơn hàng
                const paymentMethod = data.order.payment_method === 'cod' ? 'Thanh toán khi nhận hàng' : 'Thanh toán online';
                const orderStatus = data.order.status === 'pending' ? 'Chờ xác nhận' : data.order.status === 'processing' ? 'Đang xử lý' : data.order.status === 'completed' ? 'Đã hoàn tất' : data.order.status === 'cancelled' ? 'Đã hủy' : 'Không xác định';

                document.getElementById('orderId').textContent = data.order.id;
                document.getElementById('orderStatus').textContent = orderStatus;
                document.getElementById('paymentMethod').textContent = paymentMethod;
                document.getElementById('totalPrice').textContent = Number(data.order.total_price).toLocaleString('vi-VN') + 'đ';
                document.getElementById('orderDate').textContent = data.order.created_at;

                // Thông tin user
                document.getElementById('fullname').textContent = data.user.fullname;
                document.getElementById('phone').textContent = data.user.number;
                document.getElementById('address').textContent = data.order.address;
                const price = Number(data.items[0].price).toLocaleString('vi-VN');
                console.log('price', price);

                // Sản phẩm
                let html = '';
                data.items.forEach(item => {
                    html += `
                        <div class="card mb-2">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="text-start">
                                    <div><img src="/app/${item.image_urf}" alt="" class="img-fluid" style="width: 120px; height: 120px;"></div>
                                    <div>
                                        <div style="font-weight: 500;color: #333; padding: 6px 0;">${item.product_name}</div>
                                        <div style=" font-size: 14px;color: #666; padding: 6px 0;">${item.value || ''}ml</div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div style=" font-size: 14px;color: #666;">x ${item.quantity}</div>
                                    <div style="color: #e94560;font-weight: 600;">${Number(item.price).toLocaleString('vi-VN')}đ</div>
                                    
                                </div>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('productList').innerHTML = html;
            });
    }
    