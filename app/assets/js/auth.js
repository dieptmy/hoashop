// Hàm kiểm tra đăng nhập
// Hàm kiểm tra đăng nhập
async function checkLogin(username, password) {
    try {
        // Gửi yêu cầu đăng nhập tới login.php
        const response = await fetch('/app/api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
        });

        const data = await response.json();
        
        console.log('Login response:', data);

        if (data.success) {
            // Lưu thông tin user vào localStorage
            localStorage.setItem('auth', JSON.stringify({
                user_id: data.data.id,
                username: data.data.username,
                fullname: data.data.fullname,
                email: data.data.email,
                number: data.data.number,
                address: data.data.address,
                district: data.data.district,
                city: data.data.city
            }));
            return true;
        } else {
            return false;
        }
    } catch (error) {
        console.error('Error checking login:', error);
        return false;
    }
}


// Hàm lấy thông tin user đang đăng nhập
function getCurrentUser() {
    try {
        const auth = localStorage.getItem('auth');
        console.log('Auth data from localStorage:', auth);
        
        if (!auth) return null;
        
        const user = JSON.parse(auth);
        console.log('Parsed user:', user);
        return user.username;
    } catch (error) {
        console.error('Error getting current user:', error);
        return null;
    }
}

// // Hàm đăng xuất
// function logout() {
//     localStorage.removeItem('auth');
//     window.location.href = 'login.html';
// }

// Hàm xử lý form đăng nhập
async function handleLogin(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    if (await checkLogin(username, password)) {
        window.location.href = '/';
    } else {
        alert('Sai tên đăng nhập hoặc mật khẩu');
    }
}

const loginForm = document.getElementById('loginForm');
  if (loginForm) {
      loginForm.addEventListener('submit', handleLogin);
  }