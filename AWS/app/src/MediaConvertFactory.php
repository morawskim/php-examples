<?php

namespace App;

use Aws\MediaConvert\MediaConvertClient;
use Aws\Sdk;

class MediaConvertFactory
{
    public static function factoryMediaConvert(Sdk $sdk, array $args, ?string $endpoint = null): MediaConvertClient
    {
        if (null !== $endpoint) {
            $args['endpoint'] = $endpoint;
        }

        return $sdk->createMediaConvert($args);
    }
}
