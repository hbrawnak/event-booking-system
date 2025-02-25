<?php

namespace App\database;

use App\database\drivers\MySQL;
use Exception;

class DatabaseFactory
{
    public static function create($type, $config)
    {
        switch ($type) {
            case DatabaseConnectionType::MYSQL:
                return new MySQL($config);
            default:
                throw new Exception("Unsupported database type: {$type}");
        }
    }
}
