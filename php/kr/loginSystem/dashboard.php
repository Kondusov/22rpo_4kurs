<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$auth_type = isset($_COOKIE['remember_me']) ? "куки (автовход)" : "сессия";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
        .info { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .auth-info { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <h1>Добро пожаловать, <?php echo $_SESSION['user']; ?>!</h1>
    
    <div class="auth-info">
        <h3> Информация об авторизации:</h3>
        <p><strong>Тип входа:</strong> <?php echo $auth_type; ?></p>
        <p><strong>Имя пользователя:</strong> <?php echo $_SESSION['user']; ?></p>
    </div>
    
    <div class="info">
        <h3> Информация о сессии:</h3>
        <p><strong>ID сессии:</strong> <?php echo session_id(); ?></p>
        <p><strong>Время входа:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        
        <h3> Информация о куки:</h3>
        <p><strong>Запомненный вход:</strong> 
            <?php echo isset($_COOKIE['remember_me']) ? 'Да' : 'Нет'; ?>
        </p>
        <?php if (isset($_COOKIE['remember_me'])): ?>
            <p><strong>Куки установлено до:</strong> 
                <?php echo date('Y-m-d H:i:s', $_COOKIE['remember_me_expiry'] ?? time() + 2592000); ?>
            </p>
        <?php endif; ?>
    </div>
    
    <div class="info">
        <h3> Доступные действия:</h3>
        <ul>
            <li>Просмотр защищенного контента</li>
            <li>Доступ к личным данным</li>
            <li>Настройки профиля</li>
        </ul>
    </div>
    
    <p>
        <a href="index.php">На главную</a> | 
        <a href="logout.php">Выйти из системы</a>
    </p>
    
    <hr>
    <p><small>Эта страница доступна только авторизованным пользователям через сессии или куки.</small></p>
</body>
</html>