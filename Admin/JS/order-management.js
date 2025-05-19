// Lấy checkbox tổng
const selectAllCheckbox = document.getElementById('selectAll');

function addSelectAllListener() {
    const userCheckboxes = document.querySelectorAll('.userCheckbox');
    
    // Gán sự kiện cho checkbox tổng
    selectAllCheckbox.addEventListener('click', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked; // Chọn hoặc bỏ chọn tất cả các checkbox con
        });
    });
}

const orderData = [
    {
        orderID: "V1234F",
        customUser: "s1mpmirai",
        customerName: "Nguyễn Hoàng Tín",
        customerPhone: "0354986796",
        customerAddress: "273 An Dương Vương, Phường 3, Quận 5, TpHCM",
        orderDate: "2024-10-24",
        productName: "A Song for the Rose, The Voice of the Snake",
        productCode: "MT026, MT007, MT008",
        costs: "19,083,600đ",
        quantity: "MT026 (1), MT007 (2), MT008 (1)",
        status: "da_huy",
        notes: "Giao hàng sau 5h chiều"
    },
    {
        orderID: "V1235F",
        customUser: "tuentuti",
        customerName: "Nguyễn Ngọc Thùy Trang",
        customerPhone: "0354986796",
        customerAddress: "273 An Dương Vương, Phường 3, Quận 5, TpHCM",
        orderDate: "2024-10-9",
        productName: "Gucci Flora Gorgeous Magnolia, Gucci Bloom, Burberry Goddess",
        productCode: "MT026, MT007, MT008",
        costs: "13,822,500đ",
        quantity: "MT026 (1), MT007 (2), MT008 (1)",
        status: "chua_xu_ly",
        notes: "Giao hàng sau 5h chiều"
    },
    {
        orderID: "V1236F",
        customUser: "npdan167",
        customerName: "Nguyễn Phương Đan",
        customerPhone: "0354986796",
        customerAddress: "273 An Dương Vương, Phường 3, Quận 5, TpHCM",
        orderDate: "2024-10-11",
        productName: "Her, Burberry Signatures Midnight Journey, CHANEL ALLURE, CHANEL CRISTALLE",
        productCode: "MT026, MT007, MT008",
        costs: "23,285,500đ",
        quantity: "MT026 (1), MT007 (2), MT008 (1)",
        status: "hoan_thanh",
        notes: "Giao hàng sau 5h chiều"
    },
    {
        orderID: "V1237F",
        customerName: "Diệp Tiểu My",
        customUser: "dieptmy",
        customerPhone: "0354986796",
        customerAddress: "273 An Dương Vương, Phường 3, Quận 5, TpHCM",
        orderDate: "2024-10-2",
        productName: "COCO MADEMOISELLE",
        productCode: "MT026, MT007, MT008",
        costs: "5,567,000đ",
        quantity: "MT026 (1), MT007 (2), MT008 (1)",
        status: "dang_giao_hang",
        notes: "Giao hàng sau 5h chiều"
    },
    {
        orderID: "V1238F",
        customerName: "Võ Thanh Tùng",
        customUser: "TunTun-prog",
        customerPhone: "0354986796",
        customerAddress: "273 An Dương Vương, Phường 3, Quận 5, TpHCM",
        orderDate: "2024-8-15",
        productName: "GABRIELLE CHANEL, Charme Good Girl, Thierry Mugler Alien Goddess",
        productCode: "MT026, MT007, MT008",
        costs: "14,467,000đ",
        quantity: "MT026 (1), MT007 (2), MT008 (1)",
        status: "hoan_thanh",
        notes: "Giao hàng sau 5h chiều"
    },
    {
        orderID: "V1239F",
        customerName: "Nguyễn Quỳnh Anh",
        customUser: "anhnguyan",
        customerPhone: "0354986796",
        customerAddress: "273 An Dương Vương, Phường 3, Quận 5, TpHCM",
        orderDate: "2024-9-28",
        productName: "Victoria’s Secret Very Sexy 2018, Guerlain Shalimar, Gucci Guilty Pour Homme Eau De Parfum",
        productCode: "MT026, MT007, MT008",
        costs: "12,895,000đ",
        quantity: "MT026 (1), MT007 (2), MT008 (1)",
        status: "hoan_thanh",
        notes: "Giao hàng sau 5h chiều"
    },
];

// Lấy modal
var modal = document.getElementById("editProductModal");

// Lấy nút mở modal
var btn = document.getElementById("editProductBtn");

// Lấy nút đóng modal (nút "Hủy bỏ")
var closeButton = document.querySelector(".custom-close-button");

// Lấy nút đóng modal (dấu "x")
var closeSpan = document.querySelector(".close");

function openEditModal(orderIndex) {
    const order = orderData[orderIndex];

    // Điền dữ liệu của đơn hàng vào các trường trong modal
    document.getElementById("orderID").value = order.orderID;
    document.getElementById("customerName").value = order.customerName;
    document.getElementById("customerPhone").value = order.customerPhone;
    document.getElementById("customerAddress").value = order.customerAddress;
    document.getElementById("orderDate").value = order.orderDate;
    document.getElementById("productName").value = order.productName;
    document.getElementById("productCode").value = order.productCode;
    document.getElementById("quantity").value = order.quantity;
    document.getElementById("status").value = order.status;
    document.getElementById("notes").value = order.notes;

    // Hiển thị modal
    document.getElementById("editProductModal").style.display = "block";
}


document.querySelectorAll('.editProductBtn').forEach(button => {
    button.addEventListener('click', function() {
      const orderIndex = button.getAttribute('data-order-index');
      openEditModal(orderIndex);
    });
});

// Đóng modal khi ấn vào dấu "x"
closeSpan.onclick = function() {
    document.getElementById("editProductModal").style.display = "none";
};

// Khi người dùng nhấn bên ngoài modal, đóng modal
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

addSelectAllListener();

// Các phần tử cần thiết
const filterButton = document.getElementById("filterButton");
const tableSelector = document.getElementById("tableSelector");
const filterSection = document.querySelector('.filter-by-date');
const orderTable = document.getElementById("orderTable");
const productTable = document.getElementById("productTable");
const pendingOrders = document.getElementById("pendingOrders");
const deliveredOrders = document.getElementById("deliveredOrders");
const cancelledOrders = document.getElementById("cancelledOrders");
const filteredTable = document.getElementById("filteredTable");

// Hàm xử lý khi nhấn nút Lọc
filterButton.addEventListener("click", function() {
    // Đặt lại giá trị của dropdown về rỗng
    tableSelector.value = "";

    // Hiển thị bảng kết quả lọc và phần chọn bảng
    filteredTable.style.display = "table";  // Hiển thị bảng kết quả lọc
    tableSelector.style.display = "inline-block"; // Hiển thị dropdown để chọn bảng
    orderTable.style.display = "none";
    productTable.style.display = "none";
    pendingOrders.style.display = "none";
    deliveredOrders.style.display = "none";
    cancelledOrders.style.display = "none";
});

tableSelector.addEventListener("change", function () {
    // Ẩn tất cả các bảng
    orderTable.style.display = "none";
    productTable.style.display = "none";
    pendingOrders.style.display = "none";
    deliveredOrders.style.display = "none";
    cancelledOrders.style.display = "none";
    filteredTable.style.display = "none";

    // Hiển thị bảng được chọn
    if (tableSelector.value === "orders") {
        orderTable.style.display = "table";
    } else if (tableSelector.value === "products") {
        productTable.style.display = "table";
    } else if (tableSelector.value === "pendingOrders") {
        pendingOrders.style.display = "table";
    } else if (tableSelector.value === "deliveredOrders") {
        deliveredOrders.style.display = "table";
    } else if (tableSelector.value === "cancelledOrders") {
        cancelledOrders.style.display = "table";
    }
});
// Khởi tạo ban đầu: chỉ hiển thị bảng đơn hàng
orderTable.style.display = "table";
productTable.style.display = "none";
filteredTable.style.display = "none";
tableSelector.style.display = "block"; // Ẩn dropdown khi chưa bấm nút lọc


// Khởi tạo với bảng đơn hàng
loadOrderTable();
// Gán sự kiện cho nút Lọc
filterButton.addEventListener("click", filterOrdersByDate);

// Đóng modal khi nhấn vào dấu "x"
closeDetailSpan.onclick = function () {
    productDetailModal.style.display = "none";
};

// Đóng modal khi nhấn vào nút "Đóng"
closeDetailButton.onclick = function () {
    productDetailModal.style.display = "none";
};

// Đóng modal khi nhấn bên ngoài modal
window.onclick = function (event) {
    if (event.target == productDetailModal) {
        productDetailModal.style.display = "none";
    }
};


function confirmLogout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
        window.location.href = '/Admin/admin-login'; // Chuyển hướng tới trang login
    }
}

