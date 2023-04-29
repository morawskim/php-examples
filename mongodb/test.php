<?php

use MongoDB\Client;
use MongoDB\Collection;

require_once __DIR__ . '/vendor/autoload.php';

$mongo = new Client('mongodb://admin:adminpassword@mongodb:27017/admin');
$manager = $mongo->getManager();

$collection = new Collection($manager, 'testdb', 'testing');

$collection->updateOne(
    ['foo' => 'bar'],
    [
        '$set' => [
            'foo' => 'bar',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi tincidunt laoreet turpis, in sollicitudin magna maximus sed. Fusce efficitur luctus quam. Donec auctor lectus et eros finibus dignissim. Nullam laoreet, neque vel rutrum aliquam, nibh quam rutrum odio, id auctor dolor enim vel purus. Vivamus suscipit ex massa, porttitor placerat arcu gravida bibendum. Nulla tempus, justo in ullamcorper sollicitudin, nunc mi semper nulla, sed placerat risus odio et nibh. Cras laoreet leo eget dictum tincidunt. In hac habitasse platea dictumst. Maecenas facilisis, enim ac euismod molestie, dolor mauris congue nibh, eu malesuada erat massa nec libero. Morbi a risus in lacus pharetra convallis consectetur eget purus. Duis ullamcorper nulla eu magna maximus, eget congue ex ultricies. Proin tellus est, dictum eget fermentum non, congue vel mi. Morbi fringilla non lorem ut pellentesque. Phasellus lacinia, sem ut lacinia iaculis, turpis arcu viverra mauris, ac maximus eros diam sed enim. Donec ullamcorper ex in lectus ullamcorper facilisis. Curabitur eu mi quis erat elementum laoreet.',
        ]
    ],
    ['upsert' => true]
);

$documents = $collection->find([]);
var_dump($documents->toArray());
