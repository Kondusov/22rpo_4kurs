<?php
    
    if(isset($_REQUEST['checker'])){
        $name_user = $_REQUEST['name_user'];
        $age_user = $_REQUEST['age_user'];

        if(strlen($name_user ) < 4){
            echo "<h2>Ваше имя: $name_user - слишком короткое</h2><br>
            <a href="
            echo $_SERVER['HTTP_REFERER']";
            echo "'>Вернуться к форме</a>"; 
        }else{
        echo "
            <h2>Ваше имя: $name_user</h2>
            <h2>Ваше возраст: $age_user</h2>
            <h2 style='color:red'>$name_user Поздравляем Вы прошли проверку!</h2>";
        }
    }else{echo 'Вы же бот!';}
?>