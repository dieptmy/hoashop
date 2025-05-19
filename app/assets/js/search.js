console.log('search.js loaded');

// Nút tìm kiếm nâng cao
document.getElementById('toggleAdvancedSearch').onclick = function() {
    console.log('toggle advanced search');
    const adv = document.getElementById('advancedSearchForm');
    adv.style.display = adv.style.display === 'none' ? 'block' : 'none';
};



// Ẩn searchBox khi click ra ngoài
document.addEventListener('click', function(e) {
    const searchBox = document.querySelector('.searchBox');
    if (!searchBox) return;
    // Nếu click không nằm trong searchBox và không phải nút mở searchBox
    if (!searchBox.contains(e.target) && e.target.id !== 'searchBtn') {
        searchBox.style.display = 'none';
    }
});

// Khi nhấn vào nút searchBtn thì hiện searchBox
document.getElementById('searchBtn').onclick = function(e) {
    e.stopPropagation(); 
    const searchBox = document.querySelector('.searchBox');
    if (searchBox) searchBox.style.display = 'block';
};




// Tìm kiếm cơ bản
document.getElementById('basicSearchForm').onsubmit = function(e) {
    e.preventDefault();
    console.log('submit basic search');
    const keyword = document.getElementById('basicSearchInput').value.trim();
    if (!keyword) return;
    // Chuyển hướng sang trang kết quả
    window.location.href = `/index.php/search-result?keyword=${encodeURIComponent(keyword)}`;
};

// Tìm kiếm nâng cao
document.getElementById('advancedSearchForm').onsubmit = function(e) {
    e.preventDefault();
    const params = {
        keyword: document.getElementById('basicSearchInput').value.trim(),
        category: document.getElementById('categorySelect').value,
        // brand: document.getElementById('brandSelect').value,
        minPrice: document.getElementById('minPrice').value,
        maxPrice: document.getElementById('maxPrice').value
    };
   
    const query = Object.keys(params)
        .filter(key => params[key])
        .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
        .join('&');
    window.location.href = `/index.php/search-result?${query}`;
};

// // Hàm tìm kiếm sản phẩm và hiển thị kết quả
// async function searchProducts(params) {
    
//     const res = await fetch('/app/api/searchProducts.php', {
//         method: 'POST',
//         headers: { 'Content-Type': 'application/json' },
//         body: JSON.stringify(params)
//     });
//     // const data = await res.json();
//     const text = await res.text();
//     console.log(text);
//     const data = JSON.parse(text);
//     console.log(data);
//     if (!data.success || !data.products.length) {
//         document.getElementById('product-list').innerHTML = '<div class="alert alert-warning">Không tìm thấy sản phẩm phù hợp.</div>';
//         return;
//     }
    
//     // let html = '<div class="row">';
//     // data.products.forEach(p => {
//     //     html += `
//     //     <div class="col-md-3 mb-4">
//     //         <div class="card product-card">
//     //             <img src="${p.image_urf}" class="card-img-top" alt="${p.name}">
//     //             <div class="card-body">
//     //                 <h5 class="card-title">${p.name}</h5>
//     //                 <p class="card-text">Thương hiệu: ${p.brand}</p>
//     //                 <p class="card-text">Phân loại: ${p.category}</p>
//     //                 <p class="card-text text-danger">${Number(p.price).toLocaleString('vi-VN')}₫</p>
//     //                 <a href="product-detail.html?id=${p.id}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
//     //             </div>
//     //         </div>
//     //     </div>
//     //     `;
//     // });

//     const list = document.getElementById('product-list');
//             list.innerHTML = data.products.map(product => `
//               <div class="col-md-3 product-col">
//                 <div class="card product-card">
//                   <div class="product-image">
//                     <img src="/app/${product.image_urf}" class="card-img-top" alt="${product.name}">
//                   </div>
//                   <div class="card-body">
//                     <h5 class="card-title">${product.name}</h5>
//                     <p class="price">${Number(product.price).toLocaleString('vi-VN')}₫</p>
//                     <div class="brand">${product.brand}</div>
//                     <div class="d-flex gap-2" style="padding: 6px;">
//                       <button class="btn btn-primary add-to-cart" data-product-id="${product.id}">Thêm vào giỏ</button>
//                       <button class="btn btn-success buy-now" data-product-id="${product.id}">Mua ngay</button>
//                     </div>
//                   </div>
//                 </div>
//               </div>
//             `).join('');
//             }
   