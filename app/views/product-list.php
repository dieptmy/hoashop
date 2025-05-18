<div class="container-product">
    <div style="margin-top: 24px;" id="product-list" class="row">
        
    </div>
</div>

<div id="pagination-el" class="pagination-container text-center mt-4 mb-4"></div>

<script>
const urlParams = new URLSearchParams(window.location.search);
const categoryId = urlParams.get('id') || '';
const page = parseInt(urlParams.get('page')) || 1;


// if (!categoryId) {
//     document.getElementById("product-list").innerHTML = "<p class='text-danger'>Không tìm thấy danh mục sản phẩm.</p>";
//     throw new Error("Thiếu category_id trên URL");
// }
let url = `/app/api/products.php?page=${page}`;
if(categoryId) url+=`&category_id=${categoryId}`;
fetch(url)
    .then(res => res.json())
    .then(data => {
        const { limit, total } = data.pagination || {};
        const list = document.getElementById('product-list');
        const paginationEl = document.getElementById("pagination-el");

        if (!data.data || data.data.length === 0) {
            list.innerHTML = "<p class='text-danger'>Không có sản phẩm nào.</p>";
            return;
        }

        // Render sản phẩm
        list.innerHTML = data.data.map(product => `
            <div class="col-md-3 product-col">
                <div class="card product-card">
                    <div class="product-image">
                        <img src="/app/${product.image_urf}" class="card-img-top" alt="${product.name}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="price">${Number(product.price).toLocaleString('vi-VN')}₫</p>
                        
                        <div class="d-flex" style="justify-content: space-between; padding: 6px;">
                            <button class="btn btn-primary add-to-cart" data-product-id="${product.id}">Thêm vào giỏ</button>
                            <button class="btn btn-success buy-now" data-product-id="${product.id}">Mua ngay</button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');

        // Render phân trang
        const totalPages = Math.ceil(total / limit);
        let html = `<ul class="pagination justify-content-center">`;

        // Nút Previous
        html += `
            <li class="page-item ${page <= 1 ? 'disabled' : ''}">
                <a class="page-link" href="${page > 1 ? buildPageUrl(page - 1) : '#'}">&laquo;</a>
            </li>
        `;

        // Các nút số trang
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
        document.getElementById("product-list").innerHTML = "<p class='text-danger'>Lỗi khi tải sản phẩm.</p>";
        console.error("Lỗi fetch:", error);
    });


function buildPageUrl(pageNum) {
    const params = new URLSearchParams();
    params.set("id", categoryId);
    params.set("page", pageNum);
    return `/product-list?${params.toString()}`;
}


document.addEventListener('click', function (e) {
    const img = e.target.closest('.product-image img, .product-image .card-img-top');
    if (img) {
        const productCard = img.closest('.product-card');
        const productId = productCard?.querySelector('.add-to-cart')?.dataset.productId;
        if (productId) {
            window.location.href = 'product-detail?id=' + productId;
        }
    }
});
</script>
