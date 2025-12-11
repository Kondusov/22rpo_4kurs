<?php
$data_file = 'visitors.txt';

$visit_count = isset($_COOKIE['visit_count']) ? $_COOKIE['visit_count'] + 1 : 1;
setcookie('visit_count', $visit_count, time() + 3600 * 24 * 365);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']))
    {
    $data = 
    [
        'name' => $_POST['name'],
        'email' => $_POST['email'] ?? '',
        'timestamp' => date('Y-m-d H:i:s')
    ];

    $visitors = [];
    if (file_exists($data_file))
        {
        $content = file_get_contents($data_file);
        $visitors = $content ? json_decode($content, true) : [];
        if (!is_array($visitors)) {
            $visitors = [];
        }
        }
    
    $visitors[] = $data;
    
    file_put_contents($data_file, json_encode($visitors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
    }

$visitors = [];
if (file_exists($data_file))
    {
    $content = file_get_contents($data_file);
    $visitors = $content ? json_decode($content, true) : [];
    if (!is_array($visitors)) {
        $visitors = [];
    }
    }

$search = $_GET['search'] ?? '';
if ($search)
    {
    $visitors = array_filter($visitors, function($visitor) use ($search) {
        return stripos($visitor['name'], $search) !== false;
    });
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .container { margin-bottom: 30px; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        form { margin: 10px 0; }
        input, button { padding: 8px; margin: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .counter { background: #e7f3ff; padding: 10px; border-radius: 5px; }
        .file-info { background: #f0f0f0; padding: 10px; border-radius: 5px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="counter">
        <h3>Счетчик посещений (Cookies): <?= $visit_count ?></h3>
    </div>

    <div class="container">
        <h2>Добавить посетителя (POST)</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Имя" required>
            <input type="email" name="email" placeholder="Email">
            <button type="submit">Добавить в файл</button>
        </form>
    </div>

    <div class="container">
        <h2>Поиск посетителей (GET)</h2>
        <form method="get">
            <input type="text" name="search" placeholder="Поиск по имени" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Искать</button>
            <a href="?">Сбросить</a>
        </form>
    </div>

    <div class="container">
        <h2>Список посетителей (из файла)</h2>
        <?php if ($visitors): ?>
            <table>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Время добавления</th>
                </tr>
                <?php foreach ($visitors as $visitor): ?>
                <tr>
                    <td><?= htmlspecialchars($visitor['name']) ?></td>
                    <td><?= htmlspecialchars($visitor['email']) ?></td>
                    <td><?= $visitor['timestamp'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Нет данных о посетителях</p>
        <?php endif; ?>
        
        <div class="file-info">
            <h3>Информация о файле данных:</h3>
            <p>Файл: <?= $data_file ?></p>
            <p>Размер: <?= file_exists($data_file) ? filesize($data_file) : 0 ?> байт</p>
            <p>Записей: <?= count($visitors) ?></p>
        </div>
    </div>
</body>
</html>