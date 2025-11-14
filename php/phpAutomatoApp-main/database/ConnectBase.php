<?php
try{
    
    $config = require 'config.php';
    
    $db_path = __DIR__ . $config::DB_PATH;
    $db = new SQLite3($db_path);
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    echo($e->getMessage()."\n");
}