<?php

use parallel\Runtime;

if (!PHP_ZTS) {
    throw new RuntimeException('PHP has not been build with ZTS (Zend Thread Safety)');
}

$threadA = new Runtime();
$threadA->run(function () {
    while (true) {
        echo 'First thread' . PHP_EOL;
    }
});


$threadB = new Runtime();
$threadB->run(function () {
    while (true) {
        echo 'Second thread' . PHP_EOL;
    }
});

sleep(10);
$threadA->kill();
$threadB->kill();
