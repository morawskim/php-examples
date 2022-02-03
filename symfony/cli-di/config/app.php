<?php

use Symfony\Config\AppConfig;

return static function (AppConfig $appConfig) {
    $appConfig
        ->appName('AppDemo')
        ->appVersion('0.1.0');
};
