<?php

$valid = new \DateTime('+30 days');
for ($i = 0; $i < 42000; $i++) {
    $refreshToken = bin2hex(openssl_random_pseudo_bytes(64));
    $username = 'username_' . $i;
    echo generateSqlToInsert('refresh_tokens_memory', $refreshToken, $username, $valid);
    echo PHP_EOL;
    echo generateSqlToInsert('refresh_tokens_innodb', $refreshToken, $username, $valid);
    echo PHP_EOL;
}

function generateSqlToInsert(string $tableName, string $refreshToken, string $username, \DateTime $valid) {
    $dt = $valid->format('Y-m-d H:i:s');
    return "INSERT INTO `$tableName` (refresh_token, username, valid) VALUES ('$refreshToken', '$username', '$dt');";
}
