<?php
if (isset($_REQUEST['checker'])) {
    $name_user = $_REQUEST['name_user'];
    $age_user = $_REQUEST['age_user'];

<<<<<<< HEAD
        if(strlen($name_user ) < 4){
            echo "<h2>Ваше имя: $name_user - слишком короткое</h2><br>";
            echo "<a href="; echo ($_SERVER['HTTP_REFERER']);
            echo "'>Вернуться к форме</a>"; 
        }else{
        echo "
            <h2>Ваше имя: $name_user</h2>
            <h2>Ваше возраст: $age_user</h2>
            <h2 style='color:red'>$name_user Поздравляем Вы прошли проверку!</h2>";
=======
    if (strlen($name_user) < 4) {
        echo "<h2>Ваше имя: $name_user - слишком короткое</h2><br>
            <a href=";
        echo $_SERVER['HTTP_REFERER'];
        echo "'>Вернуться к форме</a>";
    } else {
        $data = "<h2>$name_user : $age_user</h2>";
        $fp = fopen('users.txt', 'a'); // Открываем файл в режиме добавления
        if ($fp) {
            fwrite($fp, "$data \n");
            fclose($fp); // Закрываем файл
        } else {
            echo "Не удалось открыть файл!";
>>>>>>> 95824065c5e9fdad9c26e2746d10623ed7552b51
        }
        // file_put_contents('users.txt', $data); // Создаст или перезапишет файл my_file.txt
        header('Location: ./');
        exit();
    }
} else {
    echo 'Вы же бот!';
}