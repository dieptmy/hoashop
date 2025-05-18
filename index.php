<?php 

require_once dirname( __FILE__ ) . '/config/db.php';
    $input = $_GET;
    $path = 'home';
    if(!empty($input['path'])) {
        if($path !== 'index') {
        $path = str_replace('.html', '', $input['path']);
        }
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="/app/assets/css/login-style.css">
    <link rel="stylesheet" href="/app/assets/css/signup-style.css">
    <link rel="stylesheet" href="./app/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./app/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="./app/assets/css/base.css">
    <link rel="stylesheet" href="./app/assets/css/header_footer.css">
    <link rel="stylesheet" href="./app/assets/css/index-style.css"> 
    <link rel="stylesheet" href="./app/assets/css/index-header.css">
    <link rel="stylesheet" href="./app/assets/css/history.css">
    <link rel="stylesheet" href="/app/assets/css/product-detail.css">
    <link rel="stylesheet" href="/app/assets/css/product-card.css">
    <link rel="stylesheet" href="/app/assets/css/shoppingcart-style.css">
    <link rel="stylesheet" href="/app/assets/css/checkout.css">
    <link rel="stylesheet" href="/app/assets/css/order-success.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./app/assets/font/fontawesome-free-6.6.0-web/fontawesome-free-6.6.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        
        <?php 
        if($path === 'home')       include 'app/views/banner.php';
        if($path !== 'login' && $path !== 'signup' && $path !== 'checkout' && $path !== 'order-success') {
            include 'app/views/header.php'; 
        }
        include 'app/views/' . $path . '.php';
        ?>
        
        <?php  if($path !== 'login' && $path !== 'signup' && $path !== 'checkout' && $path !== 'order-success') include 'app/views/footer.php'; ?>
        
    </div>

    <?php  if($path !== 'login' && $path !== 'signup' && $path !== 'checkout' && $path !== 'order-success') include 'app/views/add-cart-model.php'; ?>



    <script>
        document.addEventListener('click', function(e) {
        const img = e.target.closest('.product-image img, .product-image ');
        if (img) {
            const productId = img.dataset.productId;
            if (!productId) return;
            // Lưu vào localStorage hoặc chuyển qua query string
            // Cách 1: dùng query string
            window.location.href = '/product-detail?id=' + productId;
            console.log(productId);
        }
    });
    </script>
    
</body>
</html>