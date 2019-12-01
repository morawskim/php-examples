<?php

namespace App\utils;

use App\ConnectionManager;
use yii\db\Connection;

class ConnectionUtils
{
    public static function setupMySqlConnection()
    {
        $connection = new Connection([
            'dsn' => 'mysql:host=mysql;dbname=benchmark;port=3306',
            'username' => 'benchmark',
            'password' => 'benchmark',
            'charset' => 'UTF8',
        ]);
        $connection->open();

        $connectionManager = ConnectionManager::getInstance();
        $connectionManager->mysqlConnection = $connection;
    }

    public static function setupPostgresConnection()
    {
        $connection = new Connection([
            'dsn' => 'pgsql:host=postgres;dbname=benchmark;port=5432',
            'username' => 'benchmark',
            'password' => 'benchmark',
            'charset' => 'UTF-8',
        ]);
        $connection->open();

        $connectionManager = ConnectionManager::getInstance();
        $connectionManager->postgresConnection = $connection;
    }
}
