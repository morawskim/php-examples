<?php

namespace App;

use yii\db\Connection;

final class ConnectionManager
{
    private static $instance;

    /** @var Connection */
    public $mysqlConnection;

    /** @var Connection */
    public $postgresConnection;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
