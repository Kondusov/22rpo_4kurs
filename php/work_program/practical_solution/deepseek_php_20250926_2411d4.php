<?php
header('Content-Type: application/json');

// Подключение к БД
$pdo = new PDO("mysql:host=localhost;dbname=comments;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    
    // Валидация
    if (empty($username) || empty($comment)) {
        echo json_encode(['success' => false, 'error' => 'Все поля обязательны для заполнения']);
        exit;
    }
    
    if (strlen($username) < 2) {
        echo json_encode(['success' => false, 'error' => 'Имя должно быть не короче 2 символов']);
        exit;
    }
    
    // Сохранение в БД
    try {
        $stmt = $pdo->prepare("INSERT INTO comments (username, comment) VALUES (?, ?)");
        $stmt->execute([$username, $comment]);
        
        // Получаем добавленный комментарий
        $id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        $new_comment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'comment' => $new_comment]);
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Ошибка базы данных: ' . $e->getMessage()]);
    }
}
?>