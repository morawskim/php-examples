#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mcp\Server;
use Mcp\Server\Transport\StdioTransport;

$server = Server::builder()
    ->setServerInfo('First MCP Server', '1.0.0')
    ->setDiscovery(__DIR__, ['.', './src'])
    ->build();

$transport = new StdioTransport();

$server->run($transport);
