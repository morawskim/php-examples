<?php

namespace App\Controller;

use Aws\EventBridge\EventBridgeClient;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AwsEventBridgeController
{
    /**
     * @throws JsonException
     */
    #[Route("/event-bridge/put-events", name: 'eventbridge.put_events', methods: ['GET'])]
    public function putEvent(EventBridgeClient $client): JsonResponse
    {
        $result = $client->putEvents([
            'Entries' => [
                [
                    'Detail' => json_encode(['foo' => 'bar'], JSON_THROW_ON_ERROR),
                    'DetailType' => 'test',
                    'Source' => 'sf-demo',
                    // 'Time' => time() the default will be used
                ]
            ]
        ]);

        return new JsonResponse($result->toArray());
    }
}
