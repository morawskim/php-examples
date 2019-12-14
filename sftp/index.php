<?php

use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;

require_once __DIR__ . '/vendor/autoload.php';

$rootPath = '/tmp/';

function test(Filesystem $filesystem) {
    $path = "/helloPHP.txt";
    $contents = 'Hello from PHP';
    $response = $filesystem->put($path, $contents);
    var_dump($response);

    $path = "/helloPHP2.txt";
    $contents = 'Hello from PHP2';
    $response = $filesystem->put($path, $contents);


    $contents = $filesystem->read($path);
    var_dump($contents);


    $contents = $filesystem->listContents('/', true);
    foreach ($contents as $object) {
        echo $object['basename'].' is located at '.$object['path'].' and is a '.$object['type'];
        echo PHP_EOL;
    }
}

// password auth test
$adapter = new SftpAdapter([
    'host' => 'sftp',
    'port' => 22,
    'username' => 'userPHP',
    'password' => 'userPHPpassword',
    'root' => $rootPath,
    'timeout' => 10,
    'directoryPerm' => 0750
]);
$filesystem = new Filesystem($adapter);
echo 'test with password auth';
echo PHP_EOL;
echo PHP_EOL;
test($filesystem);
echo PHP_EOL;
echo PHP_EOL;

// privkey auth test
$adapter = new SftpAdapter([
    'host' => 'sftp',
    'port' => 22,
    'username' => 'userPHP',
    'privateKey' => '/app/ssh/id.rsa',
    'root' => $rootPath,
    'timeout' => 10,
    'directoryPerm' => 0750
]);
$filesystem = new Filesystem($adapter);

echo 'test with priv key auth';
echo PHP_EOL;
echo PHP_EOL;
test($filesystem);
echo PHP_EOL;
echo PHP_EOL;
