// // Khôi phục lại file main.js ban đầu
// document.getElementById('searchBtn').addEventListener('click', function() {
//     const searchBox = document.getElementById('searchBox');
//     if (searchBox.style.display === 'none' || searchBox.style.display === '') {
//         searchBox.style.display = 'block'; // Hiện box
//     } else {
//         searchBox.style.display = 'none'; // Ẩn box
//     }
// });

document.getElementById('accountBtn').addEventListener('click', function() {
    if (authUser) { 
        // Kiểm tra trạng thái đăng nhập
        const accountBoxHad = document.getElementById('accountBox-had');
        if (accountBoxHad) {
            if (accountBoxHad.style.display === 'none' || accountBoxHad.style.display === '') {
                accountBoxHad.style.display = 'block';
            } else {
                accountBoxHad.style.display = 'none';
            }
            
        } else {
            console.error('Phần tử accountBox-had không tồn tại!');
        }
    } else {
        const accountBoxNo = document.getElementById('accountBox-no');
        if (accountBoxNo) {
            if (accountBoxNo.style.display === 'none' || accountBoxNo.style.display === '') {
                accountBoxNo.style.display = 'block';
            } else {
                accountBoxNo.style.display = 'none';
            }
        } else {
            console.error('Phần tử accountBox-no không tồn tại!');
        }
    }
});

document.getElementById('logout').addEventListener('click', function() {
    localStorage.removeItem('auth');
    window.location.replace('login.html');
}); 