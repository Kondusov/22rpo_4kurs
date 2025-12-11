<?php
    session_start();
    if($_SESSION['isAuth'] == true){
        // var_dump($_SESSION);
        // die();
        header('Location: profile.php');
    } else {
        // echo "Hello World";
        // phpinfo();
        header('Location: auth.html');
    }
?>
