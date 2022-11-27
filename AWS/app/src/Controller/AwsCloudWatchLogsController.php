<?php

namespace App\Controller;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Due to limits we should avoid calling PutLogEvents in each request for example via monolog
 * It is better to use some buffers and send logs in batch!
 */
class AwsCloudWatchLogsController
{
    private static $applications = ['Foo', 'Bar'];
    private string $logGroup = '/application/sfdemo';

    #[Route("/logs/put-log-events-unstructured", name: 'log.put_unstructured_event', methods: ['GET'])]
    public function putUnstructuredEvent(CloudWatchLogsClient $cloudWatchLogsClient, Request $request): JsonResponse
    {
        $stream = 'unstructured';
        $sequenceToken = $this->getSequenceToken($cloudWatchLogsClient, $stream);
        $time = round(microtime(true) * 1000);

        $result = $cloudWatchLogsClient->putLogEvents([
            'logGroupName' => $this->logGroup,
            'logStreamName' => $stream,
            'logEvents' => [
                [
                    'timestamp' => $time,
                    'message' => sprintf(
                        '"%s" "%s" %d "%s"',
                        $request->getClientIp(),
                        $request->headers->get('User-Agent'),
                        $time,
                        self::$applications[array_rand(self::$applications)],
                    ),
                ]
            ],
        ] + array_filter(['sequenceToken' => $sequenceToken]));

        return new JsonResponse($result->toArray());
    }

    #[Route("/logs/put-log-events-structured", name: 'log.put_structured_event', methods: ['GET'])]
    public function putStructuredEvent(CloudWatchLogsClient $cloudWatchLogsClient, Request $request): JsonResponse
    {
        $stream = 'structured';
        $sequenceToken = $this->getSequenceToken($cloudWatchLogsClient, $stream);
        $time = round(microtime(true) * 1000);

        $result = $cloudWatchLogsClient->putLogEvents([
            'logGroupName' => $this->logGroup,
            'logStreamName' => $stream,
            'logEvents' => [
                [
                    'timestamp' => $time,
                    'message' => json_encode([
                        'ip' => $request->getClientIp(),
                        'userAgent' => $request->headers->get('User-Agent'),
                        'timestamp' => $time,
                        'app' => self::$applications[array_rand(self::$applications)]
                    ], JSON_THROW_ON_ERROR),
                ]
            ],
        ] + array_filter(['sequenceToken' => $sequenceToken]));

        return new JsonResponse($result->toArray());
    }

    private function getSequenceToken(CloudWatchLogsClient $cloudWatchLogsClient, string $streamName): ?string
    {
        // fetch existing streams
        $existingStreams =
            $cloudWatchLogsClient
                ->describeLogStreams(
                    [
                        'logGroupName' => $this->logGroup,
                        'logStreamNamePrefix' => $streamName,
                    ]
                )->get('logStreams');

        $sequenceToken = null;
        foreach ($existingStreams as $stream) {
            if ($stream['logStreamName'] === $streamName && isset($stream['uploadSequenceToken'])) {
                $sequenceToken = $stream['uploadSequenceToken'];
                break;
            }
        }

        return $sequenceToken;
    }
}
