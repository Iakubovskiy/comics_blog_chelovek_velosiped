<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизація</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Авторизація</h1>
    <form id="loginForm" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="email" class="form-label">Електронна пошта:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="button" class="btn btn-primary w-100" onclick="login()">Увійти</button>
    </form>
</div>

<script>
    function login() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        axios.post('/api/login', {
            email: email,
            password: password
        })
            .then(response => {
                const token = response.data.data.token;
                console.log(response.data['data']['token'])
                console.log(token)
                if (token) {
                    localStorage.setItem('auth_token', token);
                    redirectToChat(token);

                } else {
                    alert('Токен не отримано.');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Помилка при авторизації. Перевірте введені дані.');
            });
    }
    function redirectToChat(token) {
        axios.get('/chat', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
            .then(response => {
                console.log('Успішна відповідь від сервера:', response);
                window.location.href = '/chat';
            })
            .catch(error => {
                console.error('Помилка доступу до чату:', error);
                alert('Помилка доступу до чату. Можливо, токен недійсний.');
            });
    }
    axios.interceptors.request.use(config => {
        const token = localStorage.getItem('auth_token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    }, error => {
        return Promise.reject(error);
    });
</script>
</body>
</html>
