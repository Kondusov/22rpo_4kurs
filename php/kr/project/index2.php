<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $name = $_GET['name'] ?? 'Без значения';

    setcookie("get", $name, time() + 3600);
    file_put_contents("log.txt", "get: $name\n", FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? 'Без значения';

    setcookie("post", $name, time() + 3600);
    file_put_contents("log.txt", "post: $name\n", FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta http-equiv='refresh' content='0;' dirname(__DIR__)>
</head>
</html>