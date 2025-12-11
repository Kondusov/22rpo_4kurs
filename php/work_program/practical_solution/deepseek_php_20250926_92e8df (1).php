<?php
// Подключение к базе данных
$host = 'localhost';
$dbname = 'phonebook';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Обработка форм
$errors = [];

// Добавление контакта
if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    
    if (empty($name) || empty($phone)) {
        $errors[] = "Имя и телефон обязательны для заполнения";
    } else {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, phone, email) VALUES (?, ?, ?)");
        $stmt->execute([$name, $phone, $email]);
        header('Location: index.php');
        exit;
    }
}

// Редактирование контакта
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    
    if (empty($name) || empty($phone)) {
        $errors[] = "Имя и телефон обязательны для заполнения";
    } else {
        $stmt = $pdo->prepare("UPDATE contacts SET name = ?, phone = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $phone, $email, $id]);
        header('Location: index.php');
        exit;
    }
}

// Удаление контакта
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php');
    exit;
}

// Получение контактов
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY name");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Получение контакта для редактирования
$edit_contact = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    $edit_contact = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Телефонная книга</title>
</head>
<body>
    <h1>Телефонная книга</h1>
    
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <h2><?php echo $edit_contact ? 'Редактировать контакт' : 'Добавить контакт'; ?></h2>
    <form method="POST">
        <?php if ($edit_contact): ?>
            <input type="hidden" name="id" value="<?php echo $edit_contact['id']; ?>">
        <?php endif; ?>
        
        <p>
            <label>Имя:</label>
            <input type="text" name="name" value="<?php echo $edit_contact ? $edit_contact['name'] : ''; ?>" required>
        </p>
        
        <p>
            <label>Телефон:</label>
            <input type="text" name="phone" value="<?php echo $edit_contact ? $edit_contact['phone'] : ''; ?>" required>
        </p>
        
        <p>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $edit_contact ? $edit_contact['email'] : ''; ?>">
        </p>
        
        <button type="submit" name="<?php echo $edit_contact ? 'edit' : 'add'; ?>">
            <?php echo $edit_contact ? 'Сохранить изменения' : 'Добавить контакт'; ?>
        </button>
        
        <?php if ($edit_contact): ?>
            <a href="index.php">Отмена</a>
        <?php endif; ?>
    </form>
    
    <h2>Список контактов</h2>
    <?php if (empty($contacts)): ?>
        <p>Контактов нет</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Имя</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contact['name']); ?></td>
                    <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                    <td>
                        <a href="?edit=<?php echo $contact['id']; ?>">✏️</a>
                        <a href="?delete=<?php echo $contact['id']; ?>" onclick="return confirm('Удалить контакт?')">❌</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>