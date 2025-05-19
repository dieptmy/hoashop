<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký | vnd.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/signup-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="no-wrap">
    <div class="container">
        <div class="signup-container">
            <h2>Đăng ký</h2>
            
            <form id="signupForm" >
                <input type="text" class="form-control" id="username" placeholder="Tên đăng nhập" required>
                <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại" required>
                <input type="email" class="form-control" id="email" placeholder="Email" required>
                <input type="password" class="form-control" id="password" placeholder="Mật khẩu" required>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="check" required>
                    <label class="form-check-label" for="check">Nhớ mật khẩu</label>
        </div>
                
                <button type="submit" class="btn btn-signup">Đăng ký</button>
                
                <div class="login-text">
                    Bạn đã có tài khoản? <a href="/index.php/login">Đăng nhập</a>
            </div>
        </form>
        </div>
    </div>
</div>

    <script src="/app/assets/js/signup.js?v=1.1"></script>
</body>
</html>