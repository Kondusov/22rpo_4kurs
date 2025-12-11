<?php
session_start();

// Очистка корзины
if (isset($_GET['clear_cart'])) {
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
</head>
<body>
    <h1>Корзина покупок</h1>
    <p><a href="catalog.php">Вернуться в каталог</a></p>
    
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Корзина пуста</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
            <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $item): 
                $sum = $item['price'] * $item['quantity'];
                $total += $sum;
            ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?> руб.</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $sum; ?> руб.</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Итого:</strong></td>
                <td><strong><?php echo $total; ?> руб.</strong></td>
            </tr>
        </table>
        
        <br>
        <a href="?clear_cart=1" onclick="return confirm('Очистить корзину?')">Очистить корзину</a>
    <?php endif; ?>
</body>
</html>