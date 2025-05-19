// Lấy query string và parse thành object
function getSearchParams() {
    const params = {};
    const search = window.location.search.substring(1);
    search.split('&').forEach(pair => {
        const [key, value] = pair.split('=');
        if (key) params[decodeURIComponent(key)] = decodeURIComponent(value || '');
    });
    return params;
}

document.addEventListener('click', function(e) {
  const img = e.target.closest('.product-image img, .product-image .card-img-top');
  if (img) {
      const productCard = img.closest('.product-card');
      if (!productCard) return;
      const productId = productCard.querySelector('.add-to-cart')?.dataset.productId;
      if (!productId) return;
      window.location.href = 'product-detail?id=' + productId;
      console.log(productId);
  }
});

// Thêm biến để lưu trữ tất cả sản phẩm và số sản phẩm mỗi trang
let allProducts = [];
const productsPerPage = 12;

// Hàm hiển thị sản phẩm cho trang hiện tại
function displayProducts(page) {
    const startIndex = (page - 1) * productsPerPage;
    const endIndex = startIndex + productsPerPage;
    const productsToShow = allProducts.slice(startIndex, endIndex);
    
    const container = document.getElementById('product-list');
    container.innerHTML = productsToShow.map(product => `
        <div class="col-md-3 product-col" data-volume="${product.volume}">
            <div class="card product-card">
                <div class="product-image">
                    <img src="/app/${product.image_urf}" class="card-img-top" alt="${product.name}">
                </div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size: 16px;">${product.name}</h5>
                    <p class="price" style="font-size: 18px;">${Number(product.price).toLocaleString('vi-VN')}₫</p>
                    <div class="brand" style="font-size: 14px;">Thương hiệu: ${product.brand}</div>
                    <div class="volume" style="font-size: 14px;">Dung tích: ${product.volume}ml</div>
                    <div class="d-flex gap-2" style="padding: 6px; font-size: 16px;">
                        <button class="btn btn-primary add-to-cart" data-product-id="${product.id}">Thêm vào giỏ</button>
                        <button class="btn btn-success buy-now" data-product-id="${product.id}">Mua ngay</button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

// Hàm tạo phân trang
function createPagination(totalProducts) {
    const totalPages = Math.ceil(totalProducts / productsPerPage);
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    
    pagination.innerHTML += `
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;

    
    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `
            <li class="page-item">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }

    
    pagination.innerHTML += `
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;


    pagination.addEventListener('click', function(e) {
        e.preventDefault();
        const target = e.target;
        
        if (target.tagName === 'A') {
            const page = target.dataset.page;
            if (page) {
                displayProducts(parseInt(page));
                
                document.querySelectorAll('.pagination .page-item').forEach(item => {
                    item.classList.remove('active');
                });
                target.parentElement.classList.add('active');
            } else if (target.getAttribute('aria-label') === 'Previous') {
                const currentPage = parseInt(document.querySelector('.pagination .active a').dataset.page);
                if (currentPage > 1) {
                    displayProducts(currentPage - 1);
                }
            } else if (target.getAttribute('aria-label') === 'Next') {
                const currentPage = parseInt(document.querySelector('.pagination .active a').dataset.page);
                if (currentPage < totalPages) {
                    displayProducts(currentPage + 1);
                }
            }
        }
    });
}

// Sửa đổi hàm xử lý kết quả tìm kiếm
function handleSearchResults(data) {
    allProducts = data.products;
    
    if (allProducts.length > productsPerPage) {
        createPagination(allProducts.length);
        displayProducts(1); 
    } else {
        displayProducts(1); 
        document.getElementById('pagination').innerHTML = ''; 
    }
}

(async function() {
    const params = getSearchParams();
  
    const res = await fetch('/app/api/searchProducts.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(params)
    });
    const data = await res.json();
    const container = document.getElementById('product-list');
    if (!data.success || !data.products.length) {
        container.innerHTML = '<div class="alert alert-warning">Không tìm thấy sản phẩm phù hợp.</div>';
        return;
    }
    handleSearchResults(data);
})();
