<?php

require_once 'ConnectBase.php';

try {


//users
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    nickname TEXT NULL,
    role TEXT NOT NULL CHECK(role IN ('client', 'admin')) DEFAULT 'client'
)");

// roles
$db->exec("CREATE TABLE IF NOT EXISTS roles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT UNIQUE NOT NULL
)");

// categories
$db->exec("CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
)");

// brands
$db->exec("CREATE TABLE IF NOT EXISTS brands (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
)");

// products
$db->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price REAL NOT NULL,
    category_id INTEGER,
    brand_id INTEGER,
    FOREIGN KEY(category_id) REFERENCES categories(id),
    FOREIGN KEY(brand_id) REFERENCES brands(id)
)");

// sizes
$db->exec("CREATE TABLE IF NOT EXISTS sizes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value TEXT NOT NULL
)");

// product_inventory
$db->exec("CREATE TABLE IF NOT EXISTS product_inventory (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    size_id INTEGER,
    quantity INTEGER NOT NULL,
    reserved INTEGER DEFAULT 0,
    FOREIGN KEY(product_id) REFERENCES products(id),
    FOREIGN KEY(size_id) REFERENCES sizes(id)
)");

// product_images
$db->exec("CREATE TABLE IF NOT EXISTS product_images (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    url TEXT NOT NULL,
    FOREIGN KEY(product_id) REFERENCES products(id)
)");

// carts
// TIMESTAMP заменен на TEXT
$db->exec("CREATE TABLE IF NOT EXISTS carts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
)");

// cart_items
$db->exec("CREATE TABLE IF NOT EXISTS cart_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cart_id INTEGER,
    product_id INTEGER,
    quantity INTEGER NOT NULL,
    FOREIGN KEY(cart_id) REFERENCES carts(id),
    FOREIGN KEY(product_id) REFERENCES products(id)
)");

}
catch(Exception $e){
    echo($e->getMessage());
}
    