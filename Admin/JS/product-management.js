// Hiển thị modal thêm sản phẩm khi nhấn nút "Thêm sản phẩm"
document.getElementById("addProductBtn").addEventListener("click", function () {
    document.getElementById("addProductModal").style.display = "block";
});

// Đóng modal khi nhấn vào nút "X" hoặc ra ngoài modal
document.querySelector(".close").addEventListener("click", function () {
    closeModal('addProductModal');
    resetForm('addProductModal');
});

window.addEventListener("click", function (event) {
    const modal = document.getElementById("addProductModal");
    if (event.target === modal) {
        closeModal('addProductModal');
        resetForm('addProductModal');
    }
});

// Function to close the modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Attach the closeModal function to the 'Hủy bỏ' button in the 'Thêm Sản Phẩm' modal
document.querySelector('.cancel-add-btn').addEventListener('click', function() {
    closeModal('addProductModal'); // This closes the 'Thêm Sản Phẩm' modal
    resetForm('addProductModal');
});

// Function to open the 'Thêm Sản Phẩm' modal
function openAddProductModal() {
    document.getElementById('addProductModal').style.display = 'block';

    // Close the modal if clicked outside the modal content
    window.onclick = function(event) {
        const modal = document.getElementById('addProductModal');
        if (event.target == modal) {
            closeModal('addProductModal');
        }
    };
}

function resetForm(modalId) {
    if (modalId === 'addProductModal') {
        const form = document.getElementById('addProductForm');
        form.reset();
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = '#';  // Clear the image source
        imagePreview.style.display = 'none';  // Hide the preview
    } else if (modalId === 'editProductModal') {
        const editForm = document.getElementById('editProductForm');
        editForm.reset();
        const currentImage = document.getElementById('currentImage');
        currentImage.src = '';  // Reset the image source
    }
}

// Hiển thị ảnh xem trước khi người dùng chọn ảnh mới (Thêm sản phẩm)
document.getElementById('productImage').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});

// Function to preview new image for edit modal
function previewImage(event, targetId) {
    const targetImg = document.getElementById(targetId);
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function () {
        targetImg.src = reader.result;  // Update image source
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}

// Sample product data (you can replace this with actual data from your backend)
let products = [
    {
        id: "M000001",
        name: "A Song for the Rose",
        status: "Còn hàng",
        price: "9.541.800 VND",
        image: "IMG/Picture1.png",
        description: "Some description"
    },
    {
        id: "M000002",
        name: "The Voice of the Snake	",
        status: "Hết hàng",
        price: "9.541.800 VND",
        image: "IMG/Picture3.png",
        description: "Some description"
    },
    {
        id: "M000003",
        name: "Gucci Flora Gorgeous Magnolia",
        status: "Còn hàng",
        price: "4.174.400 VND",
        image: "IMG/Picture5.png",
        description: "Some description"
    },
    {
        id: "M000004",
        name: "Gucci Bloom",
        status: "Còn hàng",
        price: "4.174.400 VND",
        image: "IMG/Picture7.png",
        description: "Some description"
    },
    {
        id: "M000005",
        name: "Burberry Goddess",
        status: "Còn hàng",
        price: "5.473.700 VND",
        image: "IMG/Picture9.png",
        description: "Some description"
    },
];

// Function to open the edit product modal and pre-fill data
function openEditModal(productIndex) {
    const product = products[productIndex];

    // Pre-fill form data with the selected product's information
    document.getElementById('editProductId').value = product.id;
    document.getElementById('editProductName').value = product.name;
    document.getElementById('editProductStatus').value = product.status;
    document.getElementById('editProductPrice').value = product.price;
    document.getElementById('editProductDescription').value = product.description;

    // Set the image preview
    const imagePreview = document.getElementById('editImagePreview');
    imagePreview.src = product.image;
    imagePreview.style.display = 'block';

    // Open the modal
    document.getElementById('editProductModal').style.display = 'block';
}

// Function to preview the new image in the edit modal
function previewEditImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('editImagePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

window.addEventListener("click", function (event) {
    const modal = document.getElementById("editProductModal");
    if (event.target === modal) {
        closeModal('editProductModal');
    }
});

// Attach the closeModal function to the 'Hủy bỏ' button in the 'Sửa Sản Phẩm' modal
document.querySelector('#editProductModal .cancel-add-btn').addEventListener('click', function() {
    closeModal('editProductModal'); // Close the 'Sửa Sản Phẩm' modal
});

// Lắng nghe sự kiện nhấn vào nút "Xóa" trong danh sách sản phẩm
function confirmDeleteProduct(productIndex) {
    // Hiển thị thông báo xác nhận
    const confirmation = confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?");
    
    if (confirmation) {
        // Thực hiện hành động xóa sản phẩm ở đây, ví dụ như xóa khỏi mảng hoặc gọi API
        deleteProduct(productIndex);
    }
}

// Hàm để xóa sản phẩm từ mảng hoặc cập nhật lại danh sách hiển thị
function deleteProduct(productIndex) {
    // Giả sử bạn có mảng 'products' chứa các sản phẩm
    products.splice(productIndex, 1); // Xóa sản phẩm khỏi mảng

    // Cập nhật lại bảng hoặc giao diện để phản ánh sự thay đổi
    updateProductTable(); // Hàm này sẽ render lại bảng sản phẩm sau khi xóa
}


// Confirm logout
function confirmLogout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
        window.location.href = '/index.php/login';
    }
}
