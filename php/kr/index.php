<?php
header('content-type: text/plain');
if (!array_key_exists('counter', $_COOKIE)) {
    $_COOKIE['counter'] = 0;
}
$_COOKIE['counter'] += 1;
setcookie('counter', $_COOKIE['counter']);
echo "Посещений: " . $_COOKIE['counter'] . "\n\n";
$result = $_GET['cmd'];
session_start();
$file_path = './db.txt';
file_put_contents($file_path, $result . "\n", FILE_APPEND);
echo file_get_contents($file_path);
?>