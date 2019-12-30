<?php

use App\ConnectionManager;
use App\utils\ConnectionUtils;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

const MYSQL = 'mysql';
const POSTGRES = 'postgres';
const MONGO = 'mongodb';

ConnectionUtils::setupMySqlConnection();
ConnectionUtils::setupPostgresConnection();
ConnectionUtils::setupMongoDbConnection();


$stopwatch = new Stopwatch(true);
$stopwatch->start(MYSQL);
$command = ConnectionManager::getInstance()->mysqlConnection->createCommand(
    "SELECT * FROM `items` WHERE `data` ->> '$.sex' = 'FEMALE' AND `data` -> '$.pep' = true AND `data` -> '$.pepFamily' = false AND `data`  ->> '$.contactData.city' = 'Warszawa' AND `data` -> '$.questionablePersonDocument' = true LIMIT 500");
$data = $command->query()->readAll();
$event = $stopwatch->stop(MYSQL);
printProfileData(MYSQL, $event);


$stopwatch->start(POSTGRES);
$command = ConnectionManager::getInstance()->postgresConnection->createCommand(
    "SELECT * FROM items WHERE data ->> 'sex' = 'FEMALE' AND CAST(data ->> 'pep' as boolean) = true AND CAST (data ->> 'pepFamily' as boolean) = false AND data  -> 'contactData' ->> 'city' = 'Warszawa' AND CAST(data ->> 'questionablePersonDocument' as boolean) = true LIMIT 500");
$data = $command->query()->readAll();
$event = $stopwatch->stop(POSTGRES);
printProfileData(POSTGRES, $event);

$stopwatch->start(MONGO);
$command = ConnectionManager::getInstance()->mongodbConnection->createCommand()->find('items', [
  'data.sex' => 'FEMALE',
  'data.pep' => true,
  'data.pepFamily' => false,
  'data.contactData.city' => 'Warszawa',
  'data.questionablePersonDocument' => true,
], ['limit' => 500]);
$data = $command->toArray();
$event = $stopwatch->stop(MONGO);
printProfileData(MONGO, $event);

function printProfileData(string $name, StopwatchEvent $event) {
    printf('[%s] Take %f and consume %d memory', $name, $event->getDuration(), $event->getMemory());
    echo PHP_EOL;
}
