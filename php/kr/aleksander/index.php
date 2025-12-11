<?php
$db = new PDO('sqlite:db.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("
    CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        user TEXT
    )
");

session_start();

if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
} else {
    $username = 'unk';
    setcookie('username', 'unk', time() + 3600, '/');
}

if (isset($_POST['username'])) {
    $username = htmlspecialchars($_POST['username']);
    $_SESSION['username'] = $username;
    setcookie('username', $username, time() + 3600, '/');
    $stmt = $db->prepare("INSERT INTO users (user) VALUES (?)");
    $stmt->execute([$username]);
}

$result = $db->query("SELECT * FROM users");
if ($result) {
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Выводим каждую строку в ассоциативном массиве
        print_r($row);
        echo "<br>"; // Для вывода на веб-странице, в консоли не нужно
    }
} else {
    echo "Ошибка выполнения запроса: " . $db->lastErrorMsg();
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>cookie</title>
</head>
<body>
<?php echo $out; ?>
<h1>username:, <?php echo $username; ?>!</h1>

<?php if (!isset($_SESSION['username'])): ?>
    <form method="post">
        <label>name: <input type="text" name="username" required></label>
        <button type="submit">cook</button>
    </form>
<?php else: ?>
    <p>cookied</p>
    <p><a href="logout.php">logout</a></p>
<?php endif; ?>
</body>
</html>
