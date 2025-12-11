<?php
    session_start();
    if($_SESSION['isAuth'] == true){
        echo "Hello, " . $_SESSION['login'];
    }
    if(isset($_POST['logout'])){
    
        var_dump($_SESSION['isAuth']);
        // die();
        $_SESSION['isAuth'] = false;
    }
    
?>
    <form action='' method='post'>
        <input type='submit' name='logout' value='Logout'>
    </form>
    