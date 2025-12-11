<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Моя страница-визитка</title>
</head>
<body>
    <h1>Добро пожаловать на мою страницу!</h1>
    
    <?php
    // Определяем время суток
    $hour = date("H");
    if ($hour >= 6 && $hour < 12) {
        $greeting = "Доброе утро!";
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = "Добрый день!";
    } elseif ($hour >= 18 && $hour < 23) {
        $greeting = "Добрый вечер!";
    } else {
        $greeting = "Доброй ночи!";
    }
    
    // Данные о себе
    $name = "Иван";
    $surname = "Петров";
    $age = 25;
    $city = "Москва";
    
    // Массив увлечений
    $hobbies = ["Программирование", "Чтение", "Путешествия", "Фотография"];
    ?>
    
    <p><strong><?php echo $greeting; ?></strong></p>
    
    <h2>О себе:</h2>
    <p>Меня зовут: <?php echo $name . ' ' . $surname; ?></p>
    <p>Мой возраст: <?php echo $age; ?> лет</p>
    <p>Город: <?php echo $city; ?></p>
    
    <h2>Мои увлечения:</h2>
    <ul>
        <?php foreach ($hobbies as $hobby): ?>
            <li><?php echo $hobby; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>