<?php

use Symfony\Component\Console\SignalRegistry\SignalRegistry;

require_once __DIR__ . '/vendor/autoload.php';

if (!\Symfony\Component\Console\SignalRegistry\SignalRegistry::isSupported()) {
    throw new RuntimeException('Signals are not supported.');
}

$textToSend = 'my shared memory block';

$signalRegistry = new SignalRegistry();
$signalRegistry->register(SIGINT, function () {
    fprintf(STDOUT, "Signal TERM has been received\n");
    exit(0);
});

// Create shared memory block with system id of 0xff3
$shmId = shmop_open(0xff3, "n", 0644, 1024);
if (!$shmId) {
    throw new RuntimeException("Couldn't create shared memory segment");
}

// Lets write a test string into shared memory
$shmBytesWritten = shmop_write($shmId, $textToSend, 0);
if ($shmBytesWritten != strlen($textToSend)) {
    throw new RuntimeException("Couldn't write the entire length of data");
}

echo 'type "exit" to finish this script';
echo "\n";

stream_set_blocking(STDIN, false);
while (true) {
    if (($line = fgets(STDIN)) !== false) {
        if (trim($line) === 'exit') {
            break;
        }
    }

    usleep(100_000);
}
