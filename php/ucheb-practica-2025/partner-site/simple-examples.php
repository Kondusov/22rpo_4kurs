<?php
/**
 * Простые примеры использования API без класса-обертки
 */

// Базовые функции для работы с API
function api_request($endpoint, $method = 'GET', $data = null) {
    $base_url = 'http://localhost/comfort-travel-api/api/';
    $url = $base_url . $endpoint;
    
    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => $method,
            'content' => $data ? json_encode($data) : ''
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    return json_decode($result, true);
}

// Пример 1: Получить все страны
echo "<h2>Пример 1: Получить все страны</h2>";
$countries = api_request('countries');
echo "<pre>";
print_r($countries);
echo "</pre>";

// Пример 2: Создать новую страну
echo "<h2>Пример 2: Создать новую страну</h2>";
$new_country_data = [
    'name' => 'ОАЭ',
    'code' => 'AE',
    'visa_required' => false
];

$result = api_request('countries', 'POST', $new_country_data);
echo "<pre>";
print_r($result);
echo "</pre>";

// Пример 3: Получить все туры
echo "<h2>Пример 3: Получить все туры</h2>";
$tours = api_request('tours');
echo "<pre>";
print_r($tours);
echo "</pre>";

// Пример 4: Создать бронирование
echo "<h2>Пример 4: Создать бронирование</h2>";
$booking_data = [
    'client_id' => 1,
    'tour_id' => 1,
    'booking_date' => date('Y-m-d'),
    'total_price' => 85000.00,
    'notes' => 'Тестовое бронирование'
];

$booking_result = api_request('bookings', 'POST', $booking_data);
echo "<pre>";
print_r($booking_result);
echo "</pre>";

// Пример 5: Обновить статус бронирования
echo "<h2>Пример 5: Обновить статус бронирования</h2>";
if (isset($booking_result['id'])) {
    $update_data = [
        'id' => $booking_result['id'],
        'status' => 'confirmed',
        'notes' => 'Оплата получена'
    ];
    
    $update_result = api_request('bookings', 'PUT', $update_data);
    echo "<pre>";
    print_r($update_result);
    echo "</pre>";
}
?>