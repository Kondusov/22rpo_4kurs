<?php

class BankAccount {
    private $balance; // Приватное свойство, доступно только внутри класса

    public function __construct($initialBalance) {
        $this->balance = $initialBalance;
    }

    // Публичный метод для пополнения баланса
    public function deposit($amount): void {
        if ($amount > 0) {
            $this->balance += $amount;
        }
    }

    // Публичный метод для снятия средств
    public function withdraw($amount): bool {
        if ($amount > 0 && $this->balance >= $amount) {
            $this->balance -= $amount;
            return true;
        }
        return false;
    }

    // Публичный метод для получения баланса (геттер)
    public function getBalance(): float {
        return $this->balance;
    }
}

// Использование класса
$account = new BankAccount(1000);
echo "Начальный баланс: " . $account->getBalance() . "\n"; // Выведет: Начальный баланс: 1000

$account->deposit(500);
echo "Баланс после пополнения: " . $account->getBalance() . "\n"; // Выведет: Баланс после пополнения: 1500

if ($account->withdraw(200)) {
    echo "Баланс после снятия: " . $account->getBalance() . "\n"; // Выведет: Баланс после снятия: 1300
}

// Попытка прямого доступа к приватному свойству приведет к ошибке
// echo $account->balance; // Ошибка доступа
