<div class="container-product">
    <h1 id="search-title" style="font-weight: 450;font-size: 20px; padding: 20px 10px;font-style: italic; margin: 0 8px;background-color: rgb(195 181 181 / 10%); " class="mb-4"></h1>
    <div id="product-list" class="row">
        
    </div>
</div>

<div id="pagination-el" class="pagination-container text-center mt-4 mb-4"></div>

<script>
const urlParams = new URLSearchParams(window.location.search);
const categoryId = urlParams.get('category') || '';
const page = parseInt(urlParams.get('page')) || 1;
const keyword = urlParams.get('keyword') || '';
const minPrice = urlParams.get('minPrice') || '';
const maxPrice = urlParams.get('maxPrice') || '';


let url = `/app/api/products.php?page=${page}`;
if (categoryId) url += `&category_id=${categoryId}`;
if (keyword) url += `&keyword=${keyword}`;
if (minPrice) url += `&minPrice=${minPrice}`;
if (maxPrice) url += `&maxPrice=${maxPrice}`;
let categoryName = '';
switch (Number(categoryId)) {
    case 1:
        categoryName = "nam";
        break;
    case 2:
        categoryName = "nữ";
        break;
    case 3:
        categoryName = "unisex";
        break;
    case 4:
        categoryName = "chanel";
        break;
    case 5:
        categoryName = "gucci";
        break;
    default:
        categoryName = "burberry";
        break;
}




// document.getElementById("product-list").innerHTML = `<h1>KẾT QUẢ TÌM KIẾM CỦA ${keyword} & ${minPrice}&${maxPrice}</h1>`;

fetch(url)
    .then(res => res.json())
    .then(data => {
        const { limit, total } = data.pagination;
        const list = document.getElementById('product-list');
        
        const paginationEl = document.getElementById("pagination-el");
        const totalPages = Math.ceil(total / limit);

        // Hiển thị sản phẩm
        if (data.data.length === 0) {
            list.innerHTML = `<p class="text-danger">Không tìm thấy sản phẩm phù hợp.</p>`;
        } else {
            document.getElementById("search-title").innerText = 
    `Kết quả tìm kiếm của: ${keyword ? ` "${keyword} "  -  ` : ''}${categoryName ? `" ${categoryName} "  -  ` : ''}${minPrice ? `  giá từ  "${minPrice}₫"` : ''}${maxPrice ? `  đến  "${maxPrice}₫"`: ''}`;


            list.innerHTML = data.data.map(product => `
                <div class="col-md-3 product-col">
                    <div class="card product-card">
                        <div class="product-image">
                            <img src="/app/${product.image_urf}" class="card-img-top" alt="${product.name}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="price">${Number(product.minPrice).toLocaleString('vi-VN')}₫-${Number(product.maxPrice).toLocaleString('vi-VN')}₫</p>
                            
                            <div class="d-flex" style="justify-content: space-between; padding: 6px;">
                                <button class="btn btn-primary add-to-cart" data-product-id="${product.id}">Thêm vào giỏ</button>
                                <button class="btn btn-success buy-now" data-product-id="${product.id}">Mua ngay</button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Tạo pagination
        let html = `<ul class="pagination justify-content-center">`;

        // Nút Prev
        html += `
            <li class="page-item ${page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="${page > 1 ? buildPageUrl(page - 1) : '#'}">&laquo;</a>
            </li>
        `;

        for (let i = 1; i <= totalPages; i++) {
            html += `
                <li class="page-item ${i === page ? 'active' : ''}">
                    <a href="${buildPageUrl(i)}" class="page-link">${i}</a>
                </li>
            `;
        }

        // Nút Next
        html += `
            <li class="page-item ${page >= totalPages ? 'disabled' : ''}">
                <a class="page-link" href="${page < totalPages ? buildPageUrl(page + 1) : '#'}">&raquo;</a>
            </li>
        `;

        html += `</ul>`;
        paginationEl.innerHTML = html;
    })
    .catch(error => {
        document.getElementById("product-list").innerHTML = `<p class="text-danger">Không thể tải dữ liệu sản phẩm.</p>`;
        console.error('Lỗi:', error);
    });

/**
 * Tạo URL mới với trang được chỉ định và giữ các tham số lọc khác
 */
function buildPageUrl(pageNum) {
    const params = new URLSearchParams();
    if (categoryId) params.set('category_id', categoryId);
    if (keyword) params.set('keyword', keyword);
    if (minPrice) params.set('minPrice', minPrice);
    if (maxPrice) params.set('maxPrice', maxPrice);
    params.set('page', pageNum);
    return `/search-result?${params.toString()}`;
}

// Xử lý click ảnh sản phẩm để sang trang chi tiết
document.addEventListener('click', function (e) {
    const img = e.target.closest('.product-image img, .product-image .card-img-top');
    if (img) {
        const productCard = img.closest('.product-card');
        const productId = productCard?.querySelector('.add-to-cart')?.dataset.productId;
        if (productId) {
            window.location.href = `product-detail?id=${productId}`;
        }
    }
});
</script>
