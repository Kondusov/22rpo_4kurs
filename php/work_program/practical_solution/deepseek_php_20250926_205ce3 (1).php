<?php
// Подключение к БД
$pdo = new PDO("mysql:host=localhost;dbname=comments;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получение комментариев
$stmt = $pdo->query("SELECT * FROM comments ORDER BY created_at DESC");
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Комментарии с AJAX</title>
    <style>
        .comment { border: 1px solid #ccc; margin: 10px 0; padding: 10px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Гостьвая книга</h1>
    
    <div id="message"></div>
    
    <form id="commentForm">
        <p>
            <label>Имя:</label>
            <input type="text" name="username" id="username" required>
        </p>
        
        <p>
            <label>Комментарий:</label><br>
            <textarea name="comment" id="comment" rows="4" cols="50" required></textarea>
        </p>
        
        <button type="submit">Добавить комментарий</button>
    </form>
    
    <div id="comments">
        <h2>Комментарии:</h2>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                <small><?php echo $comment['created_at']; ?></small>
                <p><?php echo htmlspecialchars($comment['comment']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('add_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                messageDiv.innerHTML = '';
                
                if (data.success) {
                    messageDiv.className = 'success';
                    messageDiv.innerHTML = 'Комментарий добавлен!';
                    
                    // Добавляем новый комментарий в начало списка
                    const commentsDiv = document.getElementById('comments');
                    const newComment = document.createElement('div');
                    newComment.className = 'comment';
                    newComment.innerHTML = `
                        <strong>${data.comment.username}</strong>
                        <small>${data.comment.created_at}</small>
                        <p>${data.comment.comment}</p>
                    `;
                    
                    commentsDiv.insertBefore(newComment, commentsDiv.children[1]);
                    
                    // Очищаем форму
                    document.getElementById('commentForm').reset();
                } else {
                    messageDiv.className = 'error';
                    messageDiv.innerHTML = data.error;
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        });
    </script>
</body>
</html>