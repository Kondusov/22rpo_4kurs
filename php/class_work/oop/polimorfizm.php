<?php

// Базовый класс
class Animal {
    public function makeSound() {
        echo "Издает звук";
    }
}

// Дочерний класс Собака
class Dog extends Animal {
    // Переопределяем метод
    public function makeSound() {
        echo "Гав!";
    }
}

// Дочерний класс Кошка
class Cat extends Animal {
    // Переопределяем метод
    public function makeSound() {
        echo "Мяу!";
    }
}

// Пример использования
$dog = new Dog();
$cat = new Cat();

// Каждый объект вызывает свой вариант метода makeSound()
$dog->makeSound(); // Выведет: Гав!
$cat->makeSound(); // Выведет: Мяу!
