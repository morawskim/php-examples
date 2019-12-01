<?php

use App\ConnectionManager;
use App\utils\ConnectionUtils;
use yii\db\Command;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

const MYSQL = 'mysql';
const POSTGRES = 'postgres';

ConnectionUtils::setupMySqlConnection();
ConnectionUtils::setupPostgresConnection();

ConnectionManager::getInstance()->mysqlConnection->schemaCache = null;
ConnectionManager::getInstance()->postgresConnection->schemaCache = null;

$command = new Command();
$command->db = ConnectionManager::getInstance()->mysqlConnection;
$command->createTable('items', [
    'id' => \yii\db\mysql\Schema::TYPE_PK,
    'data' => sprintf('%s NOT NULL', \yii\db\mysql\Schema::TYPE_JSON)
]);
$command->execute();


$command = new Command();
$command->db = ConnectionManager::getInstance()->postgresConnection;
$command->createTable('items', [
    'id' => \yii\db\pgsql\Schema::TYPE_PK,
    'data' => sprintf('%s NOT NULL', \yii\db\pgsql\Schema::TYPE_JSONB)
]);
$command->execute();
