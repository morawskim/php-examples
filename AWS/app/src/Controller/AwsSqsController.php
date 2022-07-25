<?php

namespace App\Controller;

use Aws\Sqs\SqsClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AwsSqsController
{
    #[Route("/sqs/send-message", name: 'sqs.send-message', methods: ['POST'])]
    public function sendMessage(SqsClient $sqsClient, Request $request, string $sqsUrl): JsonResponse
    {
        $data = $request->request->all();

        $sqsClient->sendMessage([
            'MessageBody' => json_encode(['type' => 'dump', 'data' => $data], JSON_THROW_ON_ERROR),
            'QueueUrl' => $sqsUrl,
            'MessageAttributes' => [
                'X-RequestId' => [
                    'DataType' => 'String',
                    'StringValue' => '1234567890-1234567890'
                ],
            ],
        ]);

        return new JsonResponse();
    }

    #[Route("/sqs/receive-messages", name: 'sqs.receive-messages', methods: ['GET'])]
    public function receiveMessage(SqsClient $sqsClient, string $sqsUrl): JsonResponse
    {
        $messages = $sqsClient->receiveMessage([
            'QueueUrl' => $sqsUrl,
            'WaitTimeSeconds' => 10,
            'MaxNumberOfMessages' => 1,
            'MessageAttributeNames' => ['All']
        ]);

        $data = array_map(
            static function ($message) {
                return [
                    'body' => json_decode($message['Body'], flags: JSON_THROW_ON_ERROR),
                    'attributes' => $message['MessageAttributes'],
                    'receipt_handle' => $message['ReceiptHandle'],

                ];
            },
            $messages->get('Messages') ?? []
        );

        return new JsonResponse($data);
    }
}
