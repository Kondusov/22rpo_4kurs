<?php
session_start();

// Товары
$products = [
    1 => ['name' => 'Футболка', 'price' => 1000],
    2 => ['name' => 'Джинсы', 'price' => 2500],
    3 => ['name' => 'Кроссовки', 'price' => 3000]
];

// Добавление в корзину
if (isset($_GET['add_to_cart'])) {
    $product_id = intval($_GET['add_to_cart']);
    
    if (isset($products[$product_id])) {
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'name' => $products[$product_id]['name'],
                'price' => $products[$product_id]['price'],
                'quantity' => 1
            ];
        } else {
            $_SESSION['cart'][$product_id]['quantity']++;
        }
    }
    
    header('Location: catalog.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог товаров</title>
</head>
<body>
    <h1>Каталог товаров</h1>
    <p><a href="cart.php">Перейти в корзину (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></p>
    
    <div class="products">
        <?php foreach ($products as $id => $product): ?>
            <div class="product">
                <h3><?php echo $product['name']; ?></h3>
                <p>Цена: <?php echo $product['price']; ?> руб.</p>
                <a href="?add_to_cart=<?php echo $id; ?>">Добавить в корзину</a>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</body>
</html>