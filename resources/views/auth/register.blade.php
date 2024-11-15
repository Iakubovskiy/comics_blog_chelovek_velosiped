<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Реєстрація</h1>
    <form id="registerForm" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="name" class="form-label">Ім'я:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Нікнейм</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Електронна пошта:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Підтвердіть пароль:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Номер телефону:</label>
            <input type="number" class="form-control" id="phone_number" name="phone_number" required>
        </div>

        <button type="button" class="btn btn-primary w-100" onclick="register()">Зареєструватися</button>
    </form>
</div>

<script>
    function register() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const phoneNumber = document.getElementById('phone_number').value;
        const username = document.getElementById('username').value;

        axios.post('/api/register', {
            name: name,
            email: email,
            password: password,
            c_password: passwordConfirmation,
            phone: phoneNumber,
            login:username,
        })
            .then(response => {
                alert('Реєстрація успішна!');
                window.location.href = '/login';
            })
            .catch(error => {
                console.error(error);
                alert('Помилка при реєстрації. Перевірте введені дані.');
            });
    }
</script>
</body>
</html>
