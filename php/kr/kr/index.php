<?php
declare(strict_types=1);

$dataDir = __DIR__ . DIRECTORY_SEPARATOR . 'data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

$storagePath = $dataDir . DIRECTORY_SEPARATOR . 'bd.txt';
if (!file_exists($storagePath)) {
    file_put_contents($storagePath, '');
}

$errors = [];
$statusMessage = '';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$name = trim($_POST['name'] ?? $_GET['name'] ?? '');
$message = trim($_POST['message'] ?? $_GET['message'] ?? '');
$submitFlag = $_POST['send'] ?? $_GET['send'] ?? null;

$lastNameCookieKey = 'last_name';
$lastName = $_COOKIE[$lastNameCookieKey] ?? '';

if ($submitFlag !== null && ($method === 'POST' || $method === 'GET')) {
    if ($name === '') {
        $errors[] = 'Пожалуйста, укажите имя.';
    }
    if ($message === '') {
        $errors[] = 'Введите текст сообщения.';
    }

    if (!$errors) {
        $entry = sprintf(
            "[%s] %s: %s",
            date('Y-m-d H:i:s'),
            $name,
            $message
        );
        file_put_contents($storagePath, $entry . PHP_EOL, FILE_APPEND | LOCK_EX);
        setcookie($lastNameCookieKey, $name, time() + 7 * 24 * 3600);
        $lastName = $name;
        $statusMessage = 'Сообщение успешно сохранено.';
        $message = '';
        unset($entry);
    }
}

$messages = file($storagePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$messages = array_reverse($messages);

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">

</head>

<body>
    <div class="container">
    
        <div class="cookie-info">
            <?php if ($lastName): ?>
                Последнее имя из cookie: <strong><?= esc($lastName) ?></strong>
            <?php else: ?>
                Куки пока не установлены. Отправьте сообщение, чтобы запомнить имя.
            <?php endif; ?>
        </div>

        <?php if ($statusMessage): ?>
            <div class="status"><?= esc($statusMessage) ?></div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" value="<?= esc($name ?: $lastName) ?>" placeholder="Например, Анна">

            <label for="message">Сообщение</label>
            <textarea id="message" name="message" placeholder="Напишите что-нибудь приятное"><?= esc($message) ?></textarea>

            <button type="submit" name="send" value="1">Отправить сообщение</button>
        </form>

        <div class="messages">
            <h2>Сохранённые сообщения</h2>
            <?php if ($messages): ?>
                <ul>
                    <?php foreach ($messages as $item): ?>
                        <li><?= esc($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Записей пока нет.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

