<?php

namespace App\Controller;

use Aws\CloudWatch\CloudWatchClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AwsCloudWatchController
{
    #[Route("/cloudwatch/put-metric-data", name: 'cloudwatch.metric', methods: ['GET'])]
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

    #[Route("/cloudwatch/set-alarm-state", name: 'cloudwatch.set-alarm-state', methods: ['POST'])]
    public function setAlarmState(CloudWatchClient $cloudWatchClient, Request $request): JsonResponse
    {
        $alarm = $request->request->get('alarm');

        if (empty($alarm)) {
            throw new BadRequestHttpException('The alarm name is missing');
        }

        $cloudWatchClient->setAlarmState([
            'AlarmName' => $alarm,
            'StateValue' => 'ALARM',
            'StateReason' => 'Testing purpose',
        ]);

        return new JsonResponse();
    }
}
