<?php

require_once __DIR__ . '/MySQL.php';
require_once __DIR__ . '/DatabaseConnectionType.php';

class DatabaseFactory {
    public static function create($type, $config) {
        switch ($type) {
            case DatabaseConnectionType::MYSQL:
                return new MySQL($config);
            default:
                throw new Exception("Unsupported database type: {$type}");
        }
    }
}
