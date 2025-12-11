<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Система входа</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
        .remember { display: flex; align-items: center; gap: 8px; margin: 10px 0; }
    </style>
</head>
<body>
    <?php if (isLoggedIn()): ?>
        <div class="success">
            Вы вошли как: <strong><?php echo $_SESSION['user']; ?></strong>
            <?php if (isset($_COOKIE['remember_me'])): ?>
                <br><small>(автовход через куки)</small>
            <?php endif; ?>
        </div>
        <p><a href="dashboard.php">Перейти в личный кабинет</a></p>
        <p><a href="logout.php">Выйти</a></p>
    <?php else: ?>
        <h2>Вход в систему</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error">Неверное имя пользователя или пароль!</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['logout'])): ?>
            <div class="success">Вы успешно вышли из системы!</div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Имя пользователя:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Пароль:</label>
                <input type="password" name="password" required>
            </div>
            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Запомнить меня</label>
            </div>
            <button type="submit">Войти</button>
        </form>
        
        <p><strong>Тестовые учетные записи:</strong></p>
        <ul>
            <li>admin / password123</li>
            <li>user / hello123</li>
        </ul>
    <?php endif; ?>
</body>
</html>