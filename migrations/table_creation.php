<?php

require_once __DIR__ . '/../config/database.php';

try {
    $db = getDatabaseConnection();

    $queries = [
        "CREATE TABLE employees (
            employee_id INT AUTO_INCREMENT PRIMARY KEY,
            employee_name VARCHAR(255) NOT NULL,
            employee_mail VARCHAR(255) NOT NULL UNIQUE
        )",

        "CREATE TABLE events (
            event_id INT PRIMARY KEY,
            event_name VARCHAR(255) NOT NULL,
            event_date DATETIME NOT NULL,
            version VARCHAR(50)
        )",

        "CREATE TABLE participations (
            participation_id INT PRIMARY KEY,
            employee_id INT,
            event_id INT,
            participation_fee DECIMAL(10, 2),
            FOREIGN KEY (employee_id) REFERENCES employees(employee_id),
            FOREIGN KEY (event_id) REFERENCES events(event_id)
        )"
    ];

    foreach ($queries as $query) {
        $db->exec($query);
    }

    echo "Tables created successfully!" . PHP_EOL;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
