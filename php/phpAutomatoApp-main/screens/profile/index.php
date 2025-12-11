<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Profile</title>
</head>
<body>
    <div class="profile-screen">
        <div class="tools-bar">
            <button>Назад</button>
            <button>Корзина</button>
        </div>

        <div class="profile-info-container">
            <img class="avatar" src="../../assets/avatar.webp">
            <input class="first-name" type="text">
            <input class="second-name" type="text">
            <button>Login</button>
        </div>

        
    </div>

    <?php
    require_once '../../ConnectBase.php';

    session_start();

    $user_id = 1;
    // $user_id = $_SESSION["user_id"];
    
    
    if($user_id){
        try{

            $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            var_dump($user);
        }
        catch(Exception $e){
            echo "Ошибка: " . $e->getMessage();

        }
    }
    ?>
            
</body>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Profile</title>
</head>
<body>
    <div class="profile-screen">
        <div class="tools-bar">
            <button>Назад</button>
            <button>Корзина</button>
        </div>

        <div class="profile-info-container">
            <img class="avatar" src="../../assets/avatar.webp">
            <input class="first-name" type="text">
            <input class="second-name" type="text">
            <button>Login</button>
        </div>

        
    </div>

    <?php
    require_once '../../ConnectBase.php';

    session_start();

    $user_id = 1;
    // $user_id = $_SESSION["user_id"];
    
    
    if($user_id){
        try{

            $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            var_dump($user);
        }
        catch(Exception $e){
            echo "Ошибка: " . $e->getMessage();

        }
    }
    ?>
            
</body>
>>>>>>> b3fc30e802dcf48c769d89678835737baa17457e
</html>