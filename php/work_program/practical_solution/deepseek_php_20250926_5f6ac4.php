<?php
class Validator {
    
    public function validateEmail($email) {
        if (empty($email)) {
            return "Email не может быть пустым";
        }
        
        // Регулярное выражение для email
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (!preg_match($pattern, $email)) {
            return "Некорректный формат email";
        }
        
        return true;
    }
    
    public function validatePassword($password) {
        if (empty($password)) {
            return "Пароль не может быть пустым";
        }
        
        if (strlen($password) < 8) {
            return "Пароль должен содержать минимум 8 символов";
        }
        
        // Регулярное выражение: минимум 1 цифра и 1 заглавная буква
        $pattern = '/^(?=.*[A-Z])(?=.*\d).+$/';
        if (!preg_match($pattern, $password)) {
            return "Пароль должен содержать хотя бы одну цифру и одну заглавную букву";
        }
        
        return true;
    }
    
    public function validateName($name) {
        if (empty($name)) {
            return "Имя не может быть пустым";
        }
        
        // Регулярное выражение: только буквы, от 2 до 50 символов
        $pattern = '/^[a-zA-Zа-яА-ЯёЁ\s]{2,50}$/u';
        if (!preg_match($pattern, $name)) {
            return "Имя должно содержать только буквы (от 2 до 50 символов)";
        }
        
        return true;
    }
}
?>