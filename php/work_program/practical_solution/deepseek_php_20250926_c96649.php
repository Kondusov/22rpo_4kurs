<?php
// Функция для расчета стоимости
function calculateTotal($price, $quantity, $promo) {
    $total = $price * $quantity;
    
    if ($promo === 'SALE10') {
        $discount = $total * 0.1;
        $total -= $discount;
        return ['total' => $total, 'discount' => $discount];
    }
    
    return ['total' => $total, 'discount' => 0];
}

// Массив товаров
$products = [
    'tshirt' => ['name' => 'Футболка', 'price' => 1000],
    'mug' => ['name' => 'Кружка', 'price' => 500],
    'book' => ['name' => 'Книга', 'price' => 300]
];

$errors = [];
$result = null;

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_key = $_POST['product'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    $promo = trim($_POST['promo'] ?? '');
    
    // Валидация
    if (!isset($products[$product_key])) {
        $errors[] = "Выберите товар";
    }
    
    if ($quantity <= 0) {
        $errors[] = "Количество должно быть больше 0";
    }
    
    if (empty($errors)) {
        $product = $products[$product_key];
        $result = calculateTotal($product['price'], $quantity, $promo);
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор заказа</title>
</head>
<body>
    <h1>Калькулятор стоимости заказа</h1>
    
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <p>
            <label>Товар:</label>
            <select name="product" required>
                <option value="">-- Выберите товар --</option>
                <?php foreach ($products as $key => $product): ?>
                    <option value="<?php echo $key; ?>">
                        <?php echo $product['name']; ?> - <?php echo $product['price']; ?> руб.
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        
        <p>
            <label>Количество:</label>
            <input type="number" name="quantity" min="1" value="<?php echo $_POST['quantity'] ?? 1; ?>" required>
        </p>
        
        <p>
            <label>Промокод:</label>
            <input type="text" name="promo" value="<?php echo $_POST['promo'] ?? ''; ?>">
        </p>
        
        <button type="submit">Рассчитать</button>
    </form>
    
    <?php if ($result): ?>
        <h2>Результат расчета:</h2>
        <p>Товар: <?php echo $products[$product_key]['name']; ?></p>
        <p>Количество: <?php echo $quantity; ?></p>
        <p>Цена за единицу: <?php echo $products[$product_key]['price']; ?> руб.</p>
        <p>Скидка: <?php echo $result['discount']; ?> руб.</p>
        <p><strong>Итоговая сумма: <?php echo $result['total']; ?> руб.</strong></p>
    <?php endif; ?>
</body>
</html>