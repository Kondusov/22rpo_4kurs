<?php
require_once 'api-client.php';

// Создаем клиент API
$api = new ComfortTravelApiClient();

echo "<h1>Примеры работы с API "Комфорт-отдых"</h1>";

try {
    // ========== ПРИМЕР 1: Работа со странами ==========
    echo "<h2>1. Работа со странами</h2>";
    
    // Получить все страны
    echo "<h3>Получить все страны:</h3>";
    $countries = $api->getCountries();
    echo "<pre>" . print_r($countries, true) . "</pre>";
    
    // Создать новую страну
    echo "<h3>Создать новую страну:</h3>";
    try {
        $new_country = $api->createCountry('Кипр', 'CY', false);
        echo "<pre>" . print_r($new_country, true) . "</pre>";
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "<br>";
    }
    
    // ========== ПРИМЕР 2: Работа с клиентами ==========
    echo "<h2>2. Работа с клиентами</h2>";
    
    // Получить всех клиентов
    echo "<h3>Получить всех клиентов:</h3>";
    $clients = $api->getClients();
    echo "<pre>" . print_r($clients, true) . "</pre>";
    
    // Создать нового клиента
    echo "<h3>Создать нового клиента:</h3>";
    try {
        $new_client = $api->createClient(
            'Смирнов Александр Петрович',
            '1122334455',
            '+79161234567',
            'smirnov@example.com',
            '1990-05-20'
        );
        echo "<pre>" . print_r($new_client, true) . "</pre>";
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "<br>";
    }
    
    // Поиск клиента по email
    echo "<h3>Поиск клиента по email:</h3>";
    $found_client = $api->findClientByEmail('ivanov@mail.ru');
    echo "<pre>" . print_r($found_client, true) . "</pre>";
    
    // ========== ПРИМЕР 3: Работа с турами ==========
    echo "<h2>3. Работа с турами</h2>";
    
    // Получить все туры
    echo "<h3>Получить все туры:</h3>";
    $tours = $api->getTours();
    echo "<pre>" . print_r($tours, true) . "</pre>";
    
    // Получить доступные туры
    echo "<h3>Получить доступные туры:</h3>";
    $available_tours = $api->getAvailableTours();
    echo "<pre>" . print_r($available_tours, true) . "</pre>";
    
    // Создать новый тур
    echo "<h3>Создать новый тур:</h3>";
    try {
        $new_tour = $api->createTour(
            1, // country_id (Турция)
            'Стамбул на выходные',
            'Экскурсии по Стамбулу, посещение Голубой мечети и Гранд Базара',
            '2024-10-10',
            '2024-10-15',
            65000.00,
            15
        );
        echo "<pre>" . print_r($new_tour, true) . "</pre>";
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "<br>";
    }
    
    // ========== ПРИМЕР 4: Работа с бронированиями ==========
    echo "<h2>4. Работа с бронированиями</h2>";
    
    // Получить все бронирования
    echo "<h3>Получить все бронирования:</h3>";
    $bookings = $api->getBookings();
    echo "<pre>" . print_r($bookings, true) . "</pre>";
    
    // Создать бронирование
    echo "<h3>Создать бронирование:</h3>";
    try {
        $new_booking = $api->createBooking(
            1, // client_id
            1, // tour_id
            date('Y-m-d'), // booking_date
            85000.00,
            'Предоплата 50%'
        );
        echo "<pre>" . print_r($new_booking, true) . "</pre>";
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage() . "<br>";
    }
    
    // ========== ПРИМЕР 5: Статистика ==========
    echo "<h2>5. Статистика</h2>";
    
    $stats = $api->getToursStatistics();
    echo "<h3>Статистика по турам:</h3>";
    echo "<pre>" . print_r($stats, true) . "</pre>";
    
    // ========== ПРИМЕР 6: Полный процесс бронирования ==========
    echo "<h2>6. Полный процесс бронирования тура</h2>";
    
    // Шаг 1: Проверяем доступные туры
    echo "<h3>Шаг 1: Доступные туры</h3>";
    $available = $api->getAvailableTours();
    
    if (isset($available['data']) && count($available['data']) > 0) {
        $first_tour = $available['data'][0];
        echo "Выбран тур: " . $first_tour['name'] . " (ID: " . $first_tour['id'] . ")<br>";
        
        // Шаг 2: Проверяем, есть ли клиент
        echo "<h3>Шаг 2: Поиск клиента</h3>";
        $client = $api->findClientByEmail('newclient@example.com');
        
        if (!$client) {
            // Шаг 3: Регистрируем нового клиента
            echo "Клиент не найден. Регистрируем нового...<br>";
            $new_client = $api->createClient(
                'Новиков Дмитрий Сергеевич',
                '6677889900',
                '+79167778899',
                'newclient@example.com',
                '1995-08-15'
            );
            echo "Создан клиент с ID: " . (isset($new_client['id']) ? $new_client['id'] : '?') . "<br>";
            $client_id = 1; // В реальности нужно получить ID из ответа
        } else {
            $client_id = $client['id'];
            echo "Найден клиент: " . $client['full_name'] . " (ID: " . $client_id . ")<br>";
        }
        
        // Шаг 4: Создаем бронирование
        echo "<h3>Шаг 4: Создание бронирования</h3>";
        try {
            $booking = $api->createBooking(
                $client_id,
                $first_tour['id'],
                date('Y-m-d'),
                $first_tour['price'],
                'Новое бронирование через API'
            );
            echo "Бронирование создано успешно!<br>";
            echo "<pre>" . print_r($booking, true) . "</pre>";
            
            // Шаг 5: Подтверждаем бронирование
            echo "<h3>Шаг 5: Подтверждение бронирования</h3>";
            if (isset($booking['id'])) {
                $confirmed = $api->updateBookingStatus($booking['id'], 'confirmed', 'Оплата получена');
                echo "Бронирование подтверждено!<br>";
            }
            
        } catch (Exception $e) {
            echo "Ошибка при бронировании: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "Нет доступных туров для бронирования.<br>";
    }
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Ошибка: " . $e->getMessage() . "</h2>";
}
?>