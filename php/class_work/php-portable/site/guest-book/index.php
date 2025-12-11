<?php
if(isset($_POST['user-name']) && isset($_POST['message'])){
    $username = $_POST['user-name'];
    $message =  $_POST['message'];
    if($username!='' && $message!= ""){
    // var_dump($username);
    file_put_contents('book.txt', $username.' - '.$message."\n</br>", FILE_APPEND);
    echo 'Запись успешно добавлена';
    }else{
        echo 'Заполните поля';
    }
}

// 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>КнигаЖалоб ипредложений</title>
</head>
<body>
    <form action="" method='post'>
        <input type="text" name='user-name'>
        <textarea type="text" name='message'></textarea>
        <input type="submit">
    </form>
    <p>
        <button ><a href='alltext.php'>Смотреть все записи</a></button>
    </p>
</body>
</html>
