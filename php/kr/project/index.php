
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>PHP</title>
    <style>
    body {
        background: pink;
    }
</style>
</head>
<body>

<h2>POST форма</h2>
<!-- <?php if (!empty($info)) echo "<p style='color:green;'>$info</p>"; ?> -->

<form method="POST" action="index2.php">
    Значение:<br>
    <input type="text" name="name" required><br><br>

    <button type="submit">Отправить</button>
</form>

<h2>GET форма</h2>
<form method="GET" action="index2.php">
    Значение:<br>
    <input type="text" name="name" required><br><br>

    <button type="submit">Отправить</button>
</form>


<h2>Cookie</h2>
<p>Cookie post: 
    <b><?= $_COOKIE['post'] ?? "cookie post не установлена" ?></b>
</p>

<h2>Cookie</h2>
<p>Cookie get: 
    <b><?= $_COOKIE['get'] ?? "cookie get не установлена" ?></b>
</p>

<h2>Чтение post запросов из файла</h2>
<pre><?= file_get_contents("log.txt"); ?></pre>
</body>
</html>