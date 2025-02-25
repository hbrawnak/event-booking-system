<?php

namespace App\config;

use App\database\DatabaseConnectionType;
use App\database\DatabaseFactory;

class DBConnection
{
    public static function getConnection()
    {
        $config = [
            'host' => getenv('DB_HOST') ?: 'db',
            'port' => getenv('DB_PORT') ?: 3306,
            'database' => getenv('DB_NAME') ?: 'bookingdb',
            'username' => getenv('DB_USERNAME') ?: 'user',
            'password' => getenv('DB_PASSWORD') ?: 'password',
        ];

        try {
            $databaseType = DatabaseConnectionType::MYSQL;
            $adapter = DatabaseFactory::create($databaseType, $config);
            return $adapter->connect();
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        } catch (\Exception $e) {
            echo "An unexpected error occurred: " . $e->getMessage();
        }
    }
}
