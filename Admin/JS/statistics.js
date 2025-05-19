function showTable() {
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;
  const mainTable = document.getElementById("dataTable");
  const leastSellingTable = document.getElementById("leastSellingProductsTable");
  const potentialCustomersTable = document.getElementById("topPotentialCustomersTable");

  if (startDate && endDate) {
      mainTable.style.display = "table";
      leastSellingTable.style.display = "table";
      potentialCustomersTable.style.display = "table";
  } else {
      alert("Vui lòng chọn cả ngày bắt đầu và ngày kết thúc.");
  }
}


function viewOrderDetail(orderId) {
    // Điều hướng đến trang chi tiết đơn hàng với mã đơn hàng
    window.location.href = `order-detail.html?id=${orderId}`;
}

// Lấy modal
var modal = document.getElementById("viewProductBtn");

// Lấy nút đóng modal (dấu "x")
var closeSpan = document.querySelector(".close");

// Dữ liệu khách hàng
const customerData = [
    {
        customerID: "CUST001",
        customerName: "Nguyễn Hoàng Tín",
        customerPhone: "0354986796",
        customerAddress: "273 An Dương Vương, Phường 3, Quận 5, Tp.HCM"
    },
    {
        customerID: "CUST002",
        customerName: "Nguyễn Ngọc Thùy Trang",
        customerPhone: "0354986797",
        customerAddress: "12 Trần Phú, Phường 7, Quận 10, Tp.HCM"
    },
    {
        customerID: "CUST003",
        customerName: "Nguyễn Phương Đan",
        customerPhone: "0354986798",
        customerAddress: "5 Nguyễn Thái Học, Quận 1, Tp.HCM"
    }
];

// Dữ liệu đơn hàng
const orderData = [
    {
        orderID: "V1234F",
        customUser: "CUST001",
        productName: "A Song for the Rose",
        productCode: "MT026",
        costs: "9,541,800đ",
        quantity: "50"
    },
    {
        orderID: "V1235F",
        customUser: "CUST002",
        productName: "Gucci Flora Gorgeous Magnolia",
        productCode: "MT007",
        costs: "4,174,400đ",
        quantity: "30"
    },
    {
        orderID: "V1236F",
        customUser: "CUST003",
        productName: "CHANEL ALLURE",
        productCode: "MT008",
        costs: "6,872,300đ",
        quantity: "20"
    },
    {
      orderID: "V1236F",
      customUser: "CUST003",
      productName: "CHANEL ALLURE",
      productCode: "MT008",
      costs: "6,872,300đ",
      quantity: "20"
  },
  {
    orderID: "V1236F",
    customUser: "CUST003",
    productName: "CHANEL ALLURE",
    productCode: "MT008",
    costs: "6,872,300đ",
    quantity: "20"
}
];

// Hàm mở modal và hiển thị dữ liệu
function openEditModal(orderIndex) {
  const order = orderData[orderIndex];
  const customer = customerData.find(cust => cust.customerID === order.customUser);

  // Điền thông tin sản phẩm
  document.getElementById("orderID").value = order.orderID;
  document.getElementById("productName").value = order.productName;
  document.getElementById("productPrice").value = order.costs;

  // Điền thông tin khách hàng (điền cho 5 khách hàng, bao gồm khách hàng hiện tại và 4 khách hàng khác)
  for (let i = 0; i < 3; i++) {
      const customerIndex = i + 1;  // Tạo chỉ mục khách hàng từ 1 đến 5
      const customer = customerData[i];  // Lấy khách hàng thứ i trong mảng

      // Điền thông tin khách hàng vào các trường trong modal
      document.getElementById(`customerName${customerIndex}`).value = customer ? customer.customerName : "Không tìm thấy";
      document.getElementById(`customerID${customerIndex}`).value = customer ? customer.customerID : "Không tìm thấy";
      document.getElementById(`quantitySold${customerIndex}`).value = order.quantity; // Cùng số lượng bán cho tất cả khách hàng
  }

  // Hiển thị modal
  modal.style.display = "block";
}


// Gắn sự kiện cho các nút mở modal
document.querySelectorAll('.viewProductBtn').forEach(button => {
    button.addEventListener('click', function() {
        const orderIndex = button.getAttribute('data-order-index') - 1; // Chuyển data-order-index thành chỉ mục mảng
        openEditModal(orderIndex);
    });
});

// Đóng modal khi nhấn vào dấu "x"
closeSpan.onclick = function() {
    modal.style.display = "none";
};

// Đóng modal khi nhấn bên ngoài modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

const purchaseData = [
  {
      orderID: "P001",
      buyerID: "B001",
      products: ["Sản phẩm A", "Sản phẩm B", "Sản phẩm C"],
      quantities: [3, 2, 5],
      totalAmount: "10,000,000đ"
  },
  {
      orderID: "P002",
      buyerID: "B002",
      products: ["Sản phẩm D", "Sản phẩm E"],
      quantities: [1, 4],
      totalAmount: "6,000,000đ"
  },
  {
      orderID: "P003",
      buyerID: "B003",
      products: ["Sản phẩm F", "Sản phẩm G"],
      quantities: [2, 7],
      totalAmount: "8,500,000đ"
  },
  {
      orderID: "P004",
      buyerID: "B004",
      products: ["Sản phẩm H", "Sản phẩm I", "Sản phẩm J"],
      quantities: [6, 1, 3],
      totalAmount: "12,000,000đ"
  },
  {
      orderID: "P005",
      buyerID: "B005",
      products: ["Sản phẩm K", "Sản phẩm L", "Sản phẩm M"],
      quantities: [5, 2, 8],
      totalAmount: "15,000,000đ"
  }
];


const buyerData = [
  {
      buyerID: "B001",
      buyerName: "Nguyễn Văn A",
      buyerPhone: "0987654321",
      buyerAddress: "273 An Dương Vương, Q.5, TP.HCM"
  },
  {
      buyerID: "B002",
      buyerName: "Trần Thị B",
      buyerPhone: "0912345678",
      buyerAddress: "12 Nguyễn Huệ, Q.1, TP.HCM"
  },
  {
      buyerID: "B003",
      buyerName: "Lê Văn C",
      buyerPhone: "0933334444",
      buyerAddress: "45 Trần Phú, Q.3, TP.HCM"
  },
  {
      buyerID: "B004",
      buyerName: "Hoàng Thị D",
      buyerPhone: "0909998888",
      buyerAddress: "67 Lê Lợi, Q.1, TP.HCM"
  },
  {
      buyerID: "B005",
      buyerName: "Phạm Minh E",
      buyerPhone: "0988887777",
      buyerAddress: "89 Nguyễn Trãi, Q.5, TP.HCM"
  }
];

// Lấy modal
const modalContainer = document.getElementById("purchaseModal");

function showPurchaseModal(orderIndex) {
    const purchase = purchaseData[orderIndex];
    const buyer = buyerData.find(b => b.buyerID === purchase.buyerID);

    if (buyer) {
        // Điền thông tin khách hàng
        document.getElementById("buyerName").value = buyer.buyerName;
        document.getElementById("buyerPhone").value = buyer.buyerPhone;
        document.getElementById("buyerAddress").value = buyer.buyerAddress;

        // Điền thông tin sản phẩm
        if (purchase.products && purchase.quantities) {
            // Tách tên sản phẩm và số lượng
            const productNames = purchase.products.join("\n");
            const productQuantities = purchase.quantities.join("\n");

            // Điền vào các ô riêng biệt
            document.getElementById("productName3").value = productNames;
            document.getElementById("productQuantity").value = productQuantities;
        } else {
            // Trường hợp không có dữ liệu sản phẩm
            document.getElementById("productName3").value = "Không có dữ liệu sản phẩm";
            document.getElementById("productQuantity").value = "Không có dữ liệu số lượng";
        }
    } else {
        // Nếu không tìm thấy thông tin khách hàng
        document.getElementById("buyerName").value = "Không tìm thấy";
        document.getElementById("buyerPhone").value = "Không tìm thấy";
        document.getElementById("buyerAddress").value = "Không tìm thấy";
        document.getElementById("productName").value = "Không có dữ liệu sản phẩm";
        document.getElementById("productQuantity").value = "Không có dữ liệu số lượng";
    }

    // Hiển thị modal
    modalContainer.style.display = "block";
}



// Đóng modal
document.querySelector(".modal-close-btn").onclick = function () {
  modalContainer.style.display = "none";
};

// Đóng modal khi click ngoài modal
window.onclick = function (event) {
  if (event.target == modalContainer) {
      modalContainer.style.display = "none";
  }
};

// Gắn sự kiện mở modal vào nút
document.querySelectorAll(".purchaseModal").forEach((button, index) => {
  button.addEventListener("click", () => showPurchaseModal(index));
});


function confirmLogout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
        window.location.href = '/index.php/login'; // Chuyển hướng tới trang login
    }
}

