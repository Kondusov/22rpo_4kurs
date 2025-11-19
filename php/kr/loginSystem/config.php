<?php
session_start();

$valid_users = [
    'admin' => 'password123',
    'user' => 'hello123'
];

$cookie_name = "remember_me";
$cookie_expiry = time() + (30 * 24 * 60 * 60); 

function isLoggedIn() {
    return isset($_SESSION['user']) || checkRememberMe();
}

function login($username, $password, $remember = false) {
    global $valid_users, $cookie_name, $cookie_expiry;
    
    if (isset($valid_users[$username]) && $valid_users[$username] === $password) {
        $_SESSION['user'] = $username;
        
        if ($remember) {
            $cookie_value = $username . '|' . md5($password . 'salt');
            setcookie($cookie_name, $cookie_value, $cookie_expiry, "/");
            setcookie('remember_me_expiry', $cookie_expiry, $cookie_expiry, "/");
        }
        
        return true;
    }
    return false;
}

function checkRememberMe() {
    global $valid_users, $cookie_name;
    
    if (isset($_COOKIE[$cookie_name])) {
        list($username, $token) = explode('|', $_COOKIE[$cookie_name]);
        
        if (isset($valid_users[$username])) {
            $expected_token = md5($valid_users[$username] . 'salt');
            
            if ($token === $expected_token) {
                $_SESSION['user'] = $username;
                return true;
            }
        }
    }
    return false;
}

function logout() {
    global $cookie_name; 
    
    $_SESSION = array();
    session_destroy();
    
    setcookie($cookie_name, "", time() - 3600, "/");
    setcookie('remember_me_expiry', "", time() - 3600, "/");
}
?>