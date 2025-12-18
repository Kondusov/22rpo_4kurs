-- Создание базы данных
CREATE DATABASE IF NOT EXISTS comfort_otdyh;
USE comfort_otdyh;

-- Таблица стран
CREATE TABLE IF NOT EXISTS countries (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    code VARCHAR(10) NOT NULL UNIQUE,
    visa_required BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица клиентов
CREATE TABLE IF NOT EXISTS clients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(200) NOT NULL,
    passport_number VARCHAR(50) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    birth_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица туров
CREATE TABLE IF NOT EXISTS tours (
    id INT PRIMARY KEY AUTO_INCREMENT,
    country_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    max_people INT NOT NULL,
    available_spots INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE
);

-- Таблица бронирований (связь клиентов и туров)
CREATE TABLE IF NOT EXISTS bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_id INT NOT NULL,
    tour_id INT NOT NULL,
    booking_date DATE NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    total_price DECIMAL(10, 2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
    UNIQUE KEY unique_booking (client_id, tour_id, booking_date)
);

-- Вставка тестовых данных
INSERT INTO countries (name, code, visa_required) VALUES
('Турция', 'TR', FALSE),
('Египет', 'EG', TRUE),
('Таиланд', 'TH', TRUE),
('Испания', 'ES', TRUE),
('Италия', 'IT', TRUE);

INSERT INTO clients (full_name, passport_number, phone, email, birth_date) VALUES
('Иванов Иван Иванович', '1234567890', '+79161234567', 'ivanov@mail.ru', '1985-05-15'),
('Петрова Анна Сергеевна', '0987654321', '+79031234567', 'petrova@gmail.com', '1990-08-22'),
('Сидоров Алексей Петрович', '5678901234', '+79261234567', 'sidorov@yandex.ru', '1978-12-10');

INSERT INTO tours (country_id, name, description, start_date, end_date, price, max_people, available_spots) VALUES
(1, 'Анталия: Все включено', 'Отдых на берегу Средиземного моря', '2024-06-01', '2024-06-15', 85000.00, 20, 18),
(2, 'Хургада: Дайвинг тур', 'Погружения в Красное море', '2024-07-10', '2024-07-20', 95000.00, 15, 15),
(3, 'Пхукет: Экзотика Таиланда', 'Экскурсии по островам', '2024-08-05', '2024-08-19', 120000.00, 25, 22),
(4, 'Барселона: Искусство и море', 'Экскурсии по достопримечательностям', '2024-09-01', '2024-09-10', 110000.00, 18, 17);