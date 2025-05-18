function formatCurrency(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "đ";
}



document.querySelector('.payment-method-list').style.display = 'none';
localStorage.setItem('paymentMethod', 'cod');

document.querySelector('.change-method').onclick = function(e) {
    e.preventDefault();
    document.querySelector('.payment-method-list').style.display = 'block';
    document.querySelector('.change-method').style.display = 'none';
    document.querySelector('.payment-label.select').style.display = 'none';
};

document.querySelector('.save-method').onclick = function(e) {
    e.preventDefault();
    const checked = document.querySelector('.payment-method-list input[type="radio"]:checked');
    const paymentMethod = checked.value;
    const paymentLabel = checked.parentElement.querySelector('.payment-label').textContent;

   
    document.querySelector('.payment-label.select').textContent = paymentLabel;

   
    localStorage.setItem('paymentMethod', paymentMethod);

    
    document.querySelector('.payment-method-list').style.display = 'none';
    document.querySelector('.change-method').style.display = 'inline';
    document.querySelector('.payment-label.select').style.display = 'block';
};

    function loadUserInfo() {
    const auth = JSON.parse(localStorage.getItem('auth') || '{}');
    document.getElementById('fullname').textContent = auth.fullname || '';
    document.getElementById('phone').textContent = auth.number || '';
    document.getElementById('address').textContent = auth.address + ", " + auth.district + ", " + auth.city || '';
    // document.getElementById('district').textContent = auth.district || '';
    // document.getElementById('city').textContent = auth.city || '';
}
loadUserInfo();

document.getElementById('edit-address').onclick = async function() {
    const auth = JSON.parse(localStorage.getItem('auth') || '{}');
    document.getElementById('editFullname').value = auth.fullname || '';
    document.getElementById('editPhone').value = auth.number || '';
    document.getElementById('editAddress').value = auth.address || '';
    document.getElementById('editAddressModal').style.display = 'block';

    // Load cities
    const citySelect = document.getElementById('editCity');
    citySelect.innerHTML = '<option value="">Chọn thành phố</option>';
    const res = await fetch('/app/api/getCities.php');
    const data = await res.json();
    if (data.success) {
        data.data.forEach(city => {
            const opt = document.createElement('option');
            opt.value = city.id;
            opt.textContent = city.name;
            citySelect.appendChild(opt);
        });
    }

    // Nếu user đã có city, set value và load quận/huyện
    if (auth.city) {
        const id = await fetch('/app/api/getCities.php?city_name=' + auth.city);
        const data = await id.json();
        citySelect.value = data.city_id;
        console.log(data.city_id);
        await loadDistricts(data.city_id, auth.district);
    } else {
        document.getElementById('editDistrict').innerHTML = '<option value="">Chọn quận/huyện</option>';
    }
};

document.getElementById('cancelEditAddress').onclick = function() {
    document.getElementById('editAddressModal').style.display = 'none';
};

document.getElementById('editCity').onchange = function() {
    const cityId = this.value;
    loadDistricts(cityId);
};

async function loadDistricts(cityId, selectedDistrict = '') {
    const districtSelect = document.getElementById('editDistrict');
    districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
    if (!cityId) return;
    const res = await fetch('/app/api/getDistricts.php?city_id=' + cityId);
    const data = await res.json();
    if (data.success) {
        data.data.forEach(district => {
            const opt = document.createElement('option');
            opt.value = district.id;
            opt.textContent = district.name;
            if (district.name == selectedDistrict) opt.selected = true;
            districtSelect.appendChild(opt);
        });
    }
}

document.getElementById('saveAddress').onclick = async function() {
    const fullname = document.getElementById('editFullname').value.trim();
    const address = document.getElementById('editAddress').value.trim();
    const city = document.getElementById('editCity').options[document.getElementById('editCity').selectedIndex].text;
    const districtId = document.getElementById('editDistrict').value;
    const district = document.getElementById('editDistrict').options[document.getElementById('editDistrict').selectedIndex].text;
    if(district) {

        console.log(district);
        console.log(city);
    } else console.log("không có quận/huyện");


    if (!fullname || !address || !districtId || !district || !city) {
        alert('Vui lòng nhập đầy đủ thông tin!');
        return;
    }
    // Gửi lên server
    const auth = JSON.parse(localStorage.getItem('auth') || '{}');
    const response = await fetch('/app/api/updateUser.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            user_id: auth.id || auth.user_id,
            fullname, address, districtId
        })
    });
    const data = await response.json();
    if (data.success) {
        Object.assign(auth, {fullname, address, district, city});
        localStorage.setItem('auth', JSON.stringify(auth));
        loadUserInfo();
        document.getElementById('editAddressModal').style.display = 'none';
    } else {
        alert('Cập nhật thất bại!');
    }
};

// Hiển thị sản phẩm chọn mua
(async function() {
    
    
    const productBuy = JSON.parse(localStorage.getItem('productBuy'));
    let subtotalResult = 0;
    for (const item of productBuy) {
        const quantity = item.quantity;
        const p = item;
        document.getElementById('product-info').innerHTML += `
            <div class="card mb-3" style="max-width: 630px;padding-bottom: 30px;border: none;border-bottom: 1px solid #eee;">
                <div class="row ">
                    <div class="product-image col-md-2 col-12" style="width: 120px;height: 120px;margin-right: 20px;border: 1px solid #eee;padding: 5px;">
                        <img src="/app/${p.image_urf}" class="img-fluid rounded-start" alt="${p.name}">
                    </div>
                    <div class="info col-md-9 col-12" style="border: none;">
                        <div class="card-body">
                            <div class="card-info">
                                <p class="card-title">${p.name}</p>
                                <p class="card-volume">${p.value}ml</p>
                                </div>
                                <div class="card-quantity">
                                    <div class="card-price">${Number(p.price).toLocaleString('vi-VN')}₫</div>
                                    <div class="">x ${quantity}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        subtotalResult += p.price * quantity;
    }
    const total = subtotalResult + 50000;
    document.getElementById('subtotal').textContent = formatCurrency(subtotalResult);
    document.getElementById('total').textContent = formatCurrency(total);
})();

async function checkout() {
    const auth = JSON.parse(localStorage.getItem('auth') || '{}');
    const paymentMethod = localStorage.getItem('paymentMethod') || 'cod';
    const subtotal = document.getElementById('subtotal').textContent.replace(/[^\d]/g, '');
    const total_qty = JSON.parse(localStorage.getItem('productBuy') || '[]').reduce((sum, item) => sum + (item.quantity || 1), 0);
    const items = JSON.parse(localStorage.getItem('productBuy') || '[]');
    const created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');


    // Ghép địa chỉ
    const address = [auth.address, auth.district, auth.city].filter(Boolean).join(', ');

    // Chuẩn bị dữ liệu gửi lên server
    const res = await fetch('/app/api/addOrder.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            user_id: auth.id || auth.user_id,
            address,
            payment_method: paymentMethod,
            total_price: subtotal,
            status: 'pending',
            total_qty,
            items
        })
    });
    const data = await res.json();

    
    if (data.success) {
        console.log('data', data.order_id);
        // Xóa sản phẩm đã mua khỏi localStorage nếu muốn
        localStorage.removeItem('productBuy');
        // Chuyển sang trang hiển thị đơn hàng
        window.location.href = 'order-success?order_id=' + data.order_id;
    } else {
        alert('Đặt hàng thất bại: ' + (data.message || 'Lỗi không xác định'));
    }
}

