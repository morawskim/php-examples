<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
$entityManager = require_once __DIR__ . '/src/bootstrap.php';
return ConsoleRunner::createHelperSet($entityManager);