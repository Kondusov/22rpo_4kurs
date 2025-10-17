<?php
class Animal {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function speak(): void {
        echo "Some generic animal sound\n";
    }
}

class Cat extends Animal {
    public function __construct($name) {
        // Вызывает конструктор родительского класса
        parent::__construct($name);
    }

    public function speak(): void {
        echo "Meow!\n";
    }
}

$genericAnimal = new Animal("Generic");
$genericAnimal->speak(); // Выведет: Some generic animal sound

$cat = new Cat("Whiskers");
$cat->speak(); // Выведет: Meow!