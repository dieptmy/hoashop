async function login(event) {
    event.preventDefault();

    const usernameInput = document.getElementById('loginInput').value.trim();
    const passwordInput = document.getElementById('passwordInput').value.trim();
    const rememberMe = document.getElementById('check').checked;

    if (!usernameInput || !passwordInput) {
        alert('Vui lòng nhập đầy đủ thông tin!');
        return false;
    }

    try {
        const response = await fetch('./assets/api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${encodeURIComponent(usernameInput)}&password=${encodeURIComponent(passwordInput)}`
        });

        const result = await response.json();

        if (result.success) {
            const authData = result.data;
            localStorage.setItem('auth', JSON.stringify(authData));

            if (rememberMe) {
                localStorage.setItem('rememberedUser', JSON.stringify({
                    username: usernameInput,
                    password: passwordInput
                }));
            } else {
                localStorage.removeItem('rememberedUser');
            }

            window.location.href = "index.html";
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Lỗi khi đăng nhập:', error);
        alert('Đã xảy ra lỗi khi đăng nhập.');
    }

    return false;
}

document.getElementById('loginForm').addEventListener('submit', login);

