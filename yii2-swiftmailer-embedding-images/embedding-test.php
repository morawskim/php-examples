<?php

require_once   __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';

$appConfig = [
    'id' => 'yii2-swiftmailer-embedding-images',
    'basePath' => __DIR__ . '/app',
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true
        ],
    ],
];
Yii::$app = new \yii\console\Application($appConfig);

Yii::$app->mailer->compose('test', [])
    ->setFrom('from@example.com')
    ->setTo('to@example.com')
    ->setSubject('Message subject')
    ->send();