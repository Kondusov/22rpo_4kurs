<?php
require_once 'ConnectBase.php';

$error = '';
$email = 'user1@example.com';
$password = 'password1';

$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bindValue(1, $email, SQLITE3_TEXT);
$stmt->execute();

?>