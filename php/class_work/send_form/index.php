<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./send.php" method="POST">
        <input type="hidden" name="checker">
        <input type="text" name="name_user" placeholder="Введите имя">
        <input type="number" name="age_user" placeholder="Введите возраст" min="18">
        <button type="submit">Отправить</button>
    </form>
    <h2>Передовики производства:</h2>
    <p>
        <?php
        if (file_exists('users.txt')) {
            $content = file_get_contents('users.txt');
            echo $content;
        }
        ?>
    </p>
</body>

</html>