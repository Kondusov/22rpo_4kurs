<?php
require_once 'config.php';

logout();

header('Location: index.php?logout=1');
exit;
?>