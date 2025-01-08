<?php

require_once __DIR__ . '/DatabaseConnectionType.php';
require_once __DIR__ . '/DatabaseFactory.php';

function getDatabaseConnection() {
    $config = [
        'host' => 'db',
        'port' => 3306,
        'database' => 'bookingdb',
        'username' => 'user',
        'password' => 'password',
    ];

    try {
        $databaseType = DatabaseConnectionType::MYSQL;
        $adapter = DatabaseFactory::create($databaseType, $config);
        return $adapter->connect();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    } catch (Exception $e) {
        echo "An unexpected error occurred: " . $e->getMessage();
    }
}

