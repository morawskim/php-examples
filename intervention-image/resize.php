<?php

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

require_once __DIR__ . '/vendor/autoload.php';

// Example resize with aspect ration and disabled upsize
if ($argc != 3) {
    fprintf(STDERR, "Usage %s INPUT_IMAGE OUTPUT_IMAGE" . PHP_EOL, $argv[0]);
    exit(1);
}
$filePath = $argv[1];
$fileResizePath = $argv[2];

$manager = new ImageManager(array('driver' => 'gd'));
$img = $manager->make($filePath);
$img->resize(250, null, function (Constraint $constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
});
$img->save($fileResizePath);
