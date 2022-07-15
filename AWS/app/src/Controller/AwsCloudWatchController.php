<?php

namespace App\Controller;

use Aws\CloudWatch\CloudWatchClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AwsCloudWatchController
{
    #[Route("/cloudwatch/put-metric-data", name: 'cloudwatch', methods: ['GET'])]
    public function putMetricData(CloudWatchClient $cloudWatchClient): Response
    {
        $result = $cloudWatchClient->putMetricData([
            'Namespace' => 'sf-app',
            'MetricData' => [
                [
                    'MetricName' => 'MyMetric',
                    'Timestamp' => time(),
                    'Dimensions' => [
                        [
                            'Name' => 'hostname',
                            'Value' => (string) gethostname()
                        ],
                    ],
                    'Unit' => 'Count',
                    'Value' => 1
                ]
            ]
        ]);

        return new JsonResponse($result->toArray());
    }
}
