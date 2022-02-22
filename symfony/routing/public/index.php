<?php

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);

$request = Request::createFromGlobals();
$kernel = new Kernel();

$response = $kernel->processRequest($request);
$response->send();
