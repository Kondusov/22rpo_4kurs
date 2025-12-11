# phpAutomatoApp

**

1. Функциональные требования

  

1.1. Права доступа

1.1.1. Гость (неавторизованный пользователь)

- Просмотр товаров - доступ к каталогу товаров
    
- Фильтрация - фильтрация товаров по различным параметрам
    
- Сортировка - сортировка товаров по цене, названию и другим параметрам
    
- Поиск - поиск товаров по названию и описанию
    
- Ограничение: Не может добавлять товары в корзину
    

  

1.1.2. Авторизованный клиент

- Все возможности гостя
    
- Добавление в корзину - возможность добавлять товары в корзину для последующего оформления заказа
    

  

1.1.3. Администратор

- Все возможности авторизованного клиента +
    
- Добавление товаров - создание новых позиций в каталоге
    
- Редактирование товаров - изменение информации о существующих товарах
    
- Удаление товаров - удаление товаров из каталога
    

  
  

2. Структура базы данных

  

2.1. Таблицы

2.1.1. Пользователи (users)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|email|VARCHAR(255)|UNIQUE, NOT NULL|
|password|VARCHAR(255)|NOT NULL|
|nickname|VARCHAR(100)|NULL|

  

2.1.2. Роли (roles)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|name|VARCHAR(50)|UNIQUE, NOT NULL|

  

2.1.3. Категории (categories)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|name|VARCHAR(50)|NOT NULL|

  

2.1.4. Бренды (brands)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|name|VARCHAR(50)|NOT NULL|

  

2.1.5. Товары (products)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|name|VARCHAR(50)|NOT NULL|
|price|DECIMAL(10,2)|NOT NULL|
|category_id|INT|FOREIGN KEY|
|brand_id|INT|FOREIGN KEY|

  

2.1.6. Размеры (sizes)

|       |             |                             |
| ----- | ----------- | --------------------------- |
| Поле  | Тип         | Ограничения                 |
| id    | INT         | PRIMARY KEY, AUTO_INCREMENT |
| value | VARCHAR(50) | NOT NULL                    |

  

2.1.7. Остатки товаров (product_inventory)

|            |     |                             |
| ---------- | --- | --------------------------- |
| Поле       | Тип | Ограничения                 |
| id         | INT | PRIMARY KEY, AUTO_INCREMENT |
| product_id | INT | FOREIGN KEY                 |
| size_id    | INT | FOREIGN KEY                 |
| quantity   | INT | NOT NULL                    |
| reserved   | INT | DEFAULT 0                   |

  

2.1.8. Изображения товаров (product_images)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|product_id|INT|FOREIGN KEY|
|url|VARCHAR(50)|NOT NULL|

  

2.1.9. Корзины (carts)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|user_id|INT|FOREIGN KEY|
|created_at|TIMESTAMP|DEFAULT CURRENT_TIMESTAMP|

  

2.1.10. Элементы корзины (cart_items)

|   |   |   |
|---|---|---|
|Поле|Тип|Ограничения|
|id|INT|PRIMARY KEY, AUTO_INCREMENT|
|cart_id|INT|FOREIGN KEY|
|product_id|INT|FOREIGN KEY|
|quantity|INT|NOT NULL|

  
**
