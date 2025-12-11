<?php
    session_start();
    $login = $_REQUEST['login'];
    $password = $_REQUEST['password'];
    var_dump($login);
    $_SESSION['login'] = $login;

    if($login == 'admin' && $password == '123'){
        $_SESSION['isAuth'] = true;
        header('Location: profile.php');
    }
    else{
        echo "Login or password is incorrect";
    }