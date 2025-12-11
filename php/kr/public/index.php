<?php

require_once 'config.php';
ob_start();

$database = new Database();
$conn = $database->getConnection();

$count = 1;
if (isset($_COOKIE['count'])) {
    $count = $_COOKIE['count'] + 1;
}
setcookie('count', $count, time() + 3600);

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
    
    if ($stmt->execute()) 
    {
        echo "Пользователь добавлен успешно!<br>";
        
    } else 
    {
        echo "Ошибка: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location:" .$_SERVER['PHP_SELF']);
        exit();
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    while($row = $result->fetch_assoc())
    {
        echo "ID: " . $row["id"] . " - Имя: " . $row["name"] . " - Email: " . $row["email"] . "<br>";
    }
} else 
{
    echo "Нет данных";
}

$conn->close();
?>

<form method="post">

    <div class="db">
        <input type="text" name="name" placeholder="Имя" required>
        <input type="email" name="email" placeholder="Email" required>

        <button type="submit">Добавить пользователя</button>
    </div>

    <div class="cookies">
        <p>Куки <strong><?php echo $count ?></strong></p>
    </div>
</form>