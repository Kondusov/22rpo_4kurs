<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$visitCount = 1;


if (isset($_COOKIE['visit_count'])) {
    $visitCount = (int)$_COOKIE['visit_count'] + 1;
}


setcookie('visit_count', $visitCount, time() + (30 * 24 * 60 * 60), '/');

echo $_COOKIE['visit_count'];
$firstVisit = $_COOKIE['first_visit'] ?? date('Y-m-d H:i:s');
if (!isset($_COOKIE['first_visit'])) {
    setcookie('first_visit', $firstVisit, time() + (30 * 24 * 60 * 60), '/');
}


$lastVisit = date('Y-m-d H:i:s');
setcookie('last_visit', $lastVisit, time() + (30 * 24 * 60 * 60), '/');


if (true) {
    $action = 'reset_counter';
    
    switch ($action) {
        case 'get_data':
            getSavedData();
            break;
        case 'get_stats':
            getStatistics();
            break;
        case 'reset_counter':
            resetCounter();
            break;
        default:
            showAvailableActions();
            break;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if ($input === null) {

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';
    } else {

        $name = $input['name'] ?? '';
        $email = $input['email'] ?? '';
        $message = $input['message'] ?? '';
    }
    
    saveData($name, $email, $message);
}


function saveData($name, $email, $message) {
    $errors = [];
    

    if (empty($name)) {
        $errors[] = "Имя обязательно для заполнения";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный email";
    }
    
    if (empty($message)) {
        $errors[] = "Сообщение не может быть пустым";
    }
    
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'errors' => $errors
        ]);
        return;
    }
    
  
    $data = [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR']
    ];
    
    $filename = 'data.txt';
    $result = file_put_contents(
        $filename, 
        json_encode($data) . PHP_EOL, 
        FILE_APPEND | LOCK_EX
    );
    
    if ($result !== false) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Данные успешно сохранены',
            'data' => $data
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Ошибка при сохранении данных'
        ]);
    }
}


function getSavedData() {
    $savedData = [];
    $filename = 'data.txt';
    
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $data = json_decode($line, true);
            if ($data) {
                $savedData[] = $data;
            }
        }
        $savedData = array_reverse($savedData);
    }
    
    echo json_encode([
        'status' => 'success',
        'count' => count($savedData),
        'data' => $savedData
    ]);
}


function getStatistics() {
    global $visitCount, $firstVisit, $lastVisit;
    
    $filename = 'data.txt';
    $totalRecords = 0;
    
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $totalRecords = count($lines);
    }
    
    echo json_encode([
        'status' => 'success',
        'statistics' => [
            'visit_count' => $visitCount,
            'first_visit' => $firstVisit,
            'last_visit' => $lastVisit,
            'total_records' => $totalRecords,
            'server_time' => date('Y-m-d H:i:s'),
            'user_ip' => $_SERVER['REMOTE_ADDR']
        ]
    ]);
}


function resetCounter() {
    setcookie('visit_count', 1, time() + (30 * 24 * 60 * 60), '/');
    setcookie('first_visit', date('Y-m-d H:i:s'), time() + (30 * 24 * 60 * 60), '/');
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Счетчик сброшен'
    ]);
}


function showAvailableActions() {
    $actions = [
        'GET endpoints' => [
            '?action=get_data' => 'Получить все сохраненные данные',
            '?action=get_stats' => 'Получить статистику посещений',
            '?action=reset_counter' => 'Сбросить счетчик посещений'
        ],
        'POST endpoints' => [
            'Content-Type: application/json' => [
                'name' => 'string (required)',
                'email' => 'string (required)',
                'message' => 'string (required)'
            ],
            'Content-Type: multipart/form-data' => [
                'name' => 'string (required)',
                'email' => 'string (required)',
                'message' => 'string (required)'
            ]
        ]
    ];
    
    echo json_encode([
        'status' => 'info',
        'message' => 'Доступные API endpoints',
        'actions' => $actions
    ]);
}
echo ("<a href='http://22rpo-4kurs:8050/php/kr/german?dfjkdf=334'>GEEEEEEEEET</a>");
?>