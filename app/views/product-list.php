<div class="container-product">
    <div id="product-list" class="row">
        
    </div>
</div>

<div id="pagination-el" class="pagination-container text-center mt-4 mb-4" >
    
</div>


<script>
const urlParams = new URLSearchParams(window.location.search);
const categoryId = urlParams.get('id');
const page = urlParams.get('page') || 1;
fetch(`/app/api/products.php?category_id=${categoryId}&page=${page}`)
    .then(res => res.json())
    .then(data => {
    const { limit, total } = data.pagination;
    const list = document.getElementById('product-list');
    

    const totalPages = Math.ceil(total / limit);
    const paginationEl = document.getElementById("pagination-el");

    let html = `
        <div class="pagination-container text-center mt-4 mb-4">
            <li class="page-item">
                <a class="page-link" href="${page > 1 ? `/product-list?id=${categoryId}&page=${parseInt(page)-1}`: '#'}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
    `;

    for (let i = 1; i <= totalPages; i++) {
        html += `
            <li class="page-item">
                <a href="/product-list?id=${categoryId}&page=${i}" class="btn btn-outline-primary">${i}</a>
            </li>
        `;
    }

    html += `
            <li class="page-item">
                <a class="page-link" href="${page < totalPages ? `/product-list?id=${categoryId}&page=${parseInt(page)+1}`: '#'}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </div>
    `;

    paginationEl.innerHTML = html;



    list.innerHTML = data.data.map(product => `
        <div class="col-md-3 product-col">
        <div class="card product-card">
            <div class="product-image">
            <img src="/app/${product.image_urf}" class="card-img-top" alt="${product.name}">
            </div>
            <div class="card-body">
            <h5 class="card-title">${product.name}</h5>
            <p class="price">${Number(product.price).toLocaleString('vi-VN')}₫</p>
            <div class="brand">${product.brand}</div>
            <div class="d-flex " style="justify-content: space-between; padding: 6px;">
                <button class="btn btn-primary add-to-cart" data-product-id="${product.id}">Thêm vào giỏ</button>
                <button class="btn btn-success buy-now" data-product-id="${product.id}">Mua ngay</button>
            </div>
            </div>
        </div>
        </div>
    `).join('');
    });

    document.addEventListener('click', function(e) {
    const img = e.target.closest('.product-image img, .product-image .card-img-top');
    if (img) {
        // Lấy productId từ thẻ cha
        const productCard = img.closest('.product-card');
        if (!productCard) return;
        const productId = productCard.querySelector('.add-to-cart')?.dataset.productId;
        if (!productId) return;
        // Lưu vào localStorage hoặc chuyển qua query string
        // Cách 1: dùng query string
        window.location.href = 'product-detail.html?id=' + productId;
        console.log(productId);
        // Cách 2: dùng localStorage (nếu muốn)
        // localStorage.setItem('selectedProductId', productId);
        // window.location.href = 'product-detail.html';
    }
    });
</script>