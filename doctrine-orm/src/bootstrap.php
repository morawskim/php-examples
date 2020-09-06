<?php

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/Entity'],
    true,
    null,
    null,
    false
);

$connection = [
    'driver' => 'pdo_mysql',
    'host' => 'mysql',
    'dbname' => 'doctrine',
    'user' => 'user',
    'password' => 'userpassword',
];

return \Doctrine\ORM\EntityManager::create($connection, $config);
