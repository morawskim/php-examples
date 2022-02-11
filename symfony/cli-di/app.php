<?php

require_once __DIR__ . '/vendor/autoload.php';
$configFile = __DIR__ . '/var/config/Symfony/Config/AppConfig.php';

if (file_exists($configFile)) {
    require_once $configFile;
}

$kernel = new \App\Kernel();
$kernel->run();
