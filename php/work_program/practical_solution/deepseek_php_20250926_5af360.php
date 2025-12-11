<?php
require_once 'Validator.php';

$validator = new Validator();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Валидация
    $nameResult = $validator->validateName($name);
    $emailResult = $validator->validateEmail($email);
    $passwordResult = $validator->validatePassword($password);
    
    if ($nameResult !== true) $errors['name'] = $nameResult;
    if ($emailResult !== true) $errors['email'] = $emailResult;
    if ($passwordResult !== true) $errors['password'] = $passwordResult;
    
    // Если ошибок нет - "регистрируем" пользователя
    if (empty($errors)) {
        $success = "Регистрация прошла успешно!";
        // Здесь обычно сохраняем в базу данных
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация пользователя</h1>
    
    <?php if (isset($success)): ?>
        <div style="color: green;"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Имя:</label>
            <input type="text" name="name" value="<?php echo $_POST['name'] ?? ''; ?>">
            <?php if (isset($errors['name'])): ?>
                <span style="color: red;"><?php echo $errors['name']; ?></span>
            <?php endif; ?>
        </p>
        
        <p>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>">
            <?php if (isset($errors['email'])): ?>
                <span style="color: red;"><?php echo $errors['email']; ?></span>
            <?php endif; ?>
        </p>
        
        <p>
            <label>Пароль:</label>
            <input type="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <span style="color: red;"><?php echo $errors['password']; ?></span>
            <?php endif; ?>
        </p>
        
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>