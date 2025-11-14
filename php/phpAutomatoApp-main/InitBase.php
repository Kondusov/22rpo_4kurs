<<<<<<< HEAD
<?php

require_once 'ConnectBase.php';

try {
    // users
    $db->exec("INSERT INTO users (email, password, nickname) VALUES
        ('user1@example.com', 'password1', 'UserOne'),
        ('user2@example.com', 'password2', 'UserTwo'),
        ('user3@example.com', 'password3', 'UserThree')");

    // roles
    $db->exec("INSERT INTO roles (name) VALUES
        ('admin'),
        ('user'),
        ('guest')");

    // categories
    $db->exec("INSERT INTO categories (name) VALUES
        ('Sneakers'),
        ('Boots'),
        ('Sandals')");

    // brands
    $db->exec("INSERT INTO brands (name) VALUES
        ('Nike'),
        ('Adidas'),
        ('Puma')");

    // products
    $db->exec("INSERT INTO products (name, price, category_id, brand_id) VALUES
        ('Air Max 2023', 150.00, 1, 1),
        ('Ultraboost', 180.00, 1, 2),
        ('Classic Boot', 120.00, 2, 3)");

    // sizes
    $db->exec("INSERT INTO sizes (value) VALUES
        ('36'),
        ('37'),
        ('38'),
        ('39'),
        ('40')");

    // product_inventory
    $db->exec("INSERT INTO product_inventory (product_id, size_id, quantity, reserved) VALUES
        (1, 1, 10, 0),
        (1, 2, 15, 1),
        (2, 3, 7, 0),
        (3, 5, 20, 2)");

    // product_images
    $db->exec("INSERT INTO product_images (product_id, url) VALUES
        (1, 'images/airmax2023_1.jpg'),
        (2, 'images/ultraboost_1.jpg'),
        (3, 'images/classicboot_1.jpg')");

    // carts
    $db->exec("INSERT INTO carts (user_id) VALUES
        (1), (2)");

    // cart_items
    $db->exec("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES
        (1, 1, 2),
        (1, 2, 1),
        (2, 3, 1)");

    echo "Тестовые данные успешно добавлены.";
}
catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}

?>
=======
<?php

require_once 'ConnectBase.php';

try {
    // users
    $db->exec("INSERT INTO users (email, password, nickname) VALUES
        ('user1@example.com', 'password1', 'UserOne'),
        ('user2@example.com', 'password2', 'UserTwo'),
        ('user3@example.com', 'password3', 'UserThree')");

    // roles
    $db->exec("INSERT INTO roles (name) VALUES
        ('admin'),
        ('user'),
        ('guest')");

    // categories
    $db->exec("INSERT INTO categories (name) VALUES
        ('Sneakers'),
        ('Boots'),
        ('Sandals')");

    // brands
    $db->exec("INSERT INTO brands (name) VALUES
        ('Nike'),
        ('Adidas'),
        ('Puma')");

    // products
    $db->exec("INSERT INTO products (name, price, category_id, brand_id) VALUES
        ('Air Max 2023', 150.00, 1, 1),
        ('Ultraboost', 180.00, 1, 2),
        ('Classic Boot', 120.00, 2, 3)");

    // sizes
    $db->exec("INSERT INTO sizes (value) VALUES
        ('36'),
        ('37'),
        ('38'),
        ('39'),
        ('40')");

    // product_inventory
    $db->exec("INSERT INTO product_inventory (product_id, size_id, quantity, reserved) VALUES
        (1, 1, 10, 0),
        (1, 2, 15, 1),
        (2, 3, 7, 0),
        (3, 5, 20, 2)");

    // product_images
    $db->exec("INSERT INTO product_images (product_id, url) VALUES
        (1, 'images/airmax2023_1.jpg'),
        (2, 'images/ultraboost_1.jpg'),
        (3, 'images/classicboot_1.jpg')");

    // carts
    $db->exec("INSERT INTO carts (user_id) VALUES
        (1), (2)");

    // cart_items
    $db->exec("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES
        (1, 1, 2),
        (1, 2, 1),
        (2, 3, 1)");

    echo "Тестовые данные успешно добавлены.";
}
catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}

?>
>>>>>>> b3fc30e802dcf48c769d89678835737baa17457e
