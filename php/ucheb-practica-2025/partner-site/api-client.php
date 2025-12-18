<?php
/**
 * Класс для работы с API туристической компании "Комфорт-отдых"
 */
class ComfortTravelApiClient {
    private $base_url;
    private $timeout = 30;
    
    public function __construct($base_url = 'http://22rpo-4kurs:8050/php/ucheb-practica-2025/comfort-travel-api/api') {
        $this->base_url = rtrim($base_url, '/');
    }
    
    /**
     * Выполнить HTTP запрос
     */
    private function makeRequest($endpoint, $method = 'GET', $data = null) {
        $url = $this->base_url . '/api/' . ltrim($endpoint, '/');
        
        $ch = curl_init();
        
        // Настройки cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        // Настройка метода и данных
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif ($method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }
        
        // Выполнение запроса
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }
        
        $result = json_decode($response, true);
        
        if ($http_code >= 400) {
            $error_msg = isset($result['message']) ? $result['message'] : 'Unknown error';
            throw new Exception("API Error ({$http_code}): " . $error_msg);
        }
        
        return $result;
    }
    
    // ========== МЕТОДЫ ДЛЯ СТРАН ==========
    
    /**
     * Получить все страны
     */
    public function getCountries() {
        return $this->makeRequest('countries', 'GET');
    }
    
    /**
     * Получить страну по ID
     */
    public function getCountry($id) {
        // Если в API есть endpoint для получения одной страны
        return $this->makeRequest("countries/{$id}", 'GET');
    }
    
    /**
     * Создать новую страну
     */
    public function createCountry($name, $code, $visa_required = false) {
        $data = [
            'name' => $name,
            'code' => $code,
            'visa_required' => $visa_required
        ];
        
        return $this->makeRequest('countries', 'POST', $data);
    }
    
    /**
     * Обновить страну
     */
    public function updateCountry($id, $name, $code, $visa_required = false) {
        $data = [
            'id' => $id,
            'name' => $name,
            'code' => $code,
            'visa_required' => $visa_required
        ];
        
        return $this->makeRequest('countries', 'PUT', $data);
    }
    
    /**
     * Удалить страну
     */
    public function deleteCountry($id) {
        $data = ['id' => $id];
        return $this->makeRequest('countries', 'DELETE', $data);
    }
    
    // ========== МЕТОДЫ ДЛЯ КЛИЕНТОВ ==========
    
    /**
     * Получить всех клиентов
     */
    public function getClients() {
        return $this->makeRequest('clients', 'GET');
    }
    
    /**
     * Создать нового клиента
     */
    public function createClient($full_name, $passport_number, $phone, $email, $birth_date) {
        $data = [
            'full_name' => $full_name,
            'passport_number' => $passport_number,
            'phone' => $phone,
            'email' => $email,
            'birth_date' => $birth_date
        ];
        
        return $this->makeRequest('clients', 'POST', $data);
    }
    
    /**
     * Обновить клиента
     */
    public function updateClient($id, $full_name, $passport_number, $phone, $email, $birth_date) {
        $data = [
            'id' => $id,
            'full_name' => $full_name,
            'passport_number' => $passport_number,
            'phone' => $phone,
            'email' => $email,
            'birth_date' => $birth_date
        ];
        
        return $this->makeRequest('clients', 'PUT', $data);
    }
    
    /**
     * Удалить клиента
     */
    public function deleteClient($id) {
        $data = ['id' => $id];
        return $this->makeRequest('clients', 'DELETE', $data);
    }
    
    // ========== МЕТОДЫ ДЛЯ ТУРОВ ==========
    
    /**
     * Получить все туры
     */
    public function getTours() {
        return $this->makeRequest('tours', 'GET');
    }
    
    /**
     * Получить доступные туры
     */
    public function getAvailableTours() {
        return $this->makeRequest('tours/available', 'GET');
    }
    
    /**
     * Создать новый тур
     */
    public function createTour($country_id, $name, $description, $start_date, $end_date, $price, $max_people, $available_spots = null) {
        if ($available_spots === null) {
            $available_spots = $max_people;
        }
        
        $data = [
            'country_id' => $country_id,
            'name' => $name,
            'description' => $description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'price' => $price,
            'max_people' => $max_people,
            'available_spots' => $available_spots
        ];
        
        return $this->makeRequest('tours', 'POST', $data);
    }
    
    // ========== МЕТОДЫ ДЛЯ БРОНИРОВАНИЙ ==========
    
    /**
     * Получить все бронирования
     */
    public function getBookings() {
        return $this->makeRequest('bookings', 'GET');
    }
    
    /**
     * Создать бронирование
     */
    public function createBooking($client_id, $tour_id, $booking_date, $total_price, $notes = '') {
        $data = [
            'client_id' => $client_id,
            'tour_id' => $tour_id,
            'booking_date' => $booking_date,
            'total_price' => $total_price,
            'notes' => $notes
        ];
        
        return $this->makeRequest('bookings', 'POST', $data);
    }
    
    /**
     * Обновить статус бронирования
     */
    public function updateBookingStatus($id, $status, $notes = '') {
        $data = [
            'id' => $id,
            'status' => $status,
            'notes' => $notes
        ];
        
        return $this->makeRequest('bookings', 'PUT', $data);
    }
    
    /**
     * Отменить бронирование
     */
    public function cancelBooking($id) {
        $data = ['id' => $id];
        return $this->makeRequest('bookings', 'DELETE', $data);
    }
    
    // ========== ПОИСК И ФИЛЬТРАЦИЯ ==========
    
    /**
     * Поиск туров по стране
     */
    public function searchToursByCountry($country_id) {
        $all_tours = $this->getTours();
        $filtered = [];
        
        if (isset($all_tours['data'])) {
            foreach ($all_tours['data'] as $tour) {
                if ($tour['country_id'] == $country_id) {
                    $filtered[] = $tour;
                }
            }
        }
        
        return ['data' => $filtered];
    }
    
    /**
     * Поиск клиента по email
     */
    public function findClientByEmail($email) {
        $all_clients = $this->getClients();
        
        if (isset($all_clients['data'])) {
            foreach ($all_clients['data'] as $client) {
                if ($client['email'] == $email) {
                    return $client;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Получить статистику по турам
     */
    public function getToursStatistics() {
        $tours = $this->getTours();
        
        if (!isset($tours['data'])) {
            return [];
        }
        
        $stats = [
            'total' => 0,
            'available' => 0,
            'booked' => 0,
            'total_revenue' => 0,
            'by_country' => []
        ];
        
        foreach ($tours['data'] as $tour) {
            $stats['total']++;
            $stats['available'] += $tour['available_spots'];
            $stats['booked'] += ($tour['max_people'] - $tour['available_spots']);
            $stats['total_revenue'] += ($tour['price'] * ($tour['max_people'] - $tour['available_spots']));
            
            $country_name = isset($tour['country_name']) ? $tour['country_name'] : 'Unknown';
            if (!isset($stats['by_country'][$country_name])) {
                $stats['by_country'][$country_name] = 0;
            }
            $stats['by_country'][$country_name]++;
        }
        
        return $stats;
    }
}
?>