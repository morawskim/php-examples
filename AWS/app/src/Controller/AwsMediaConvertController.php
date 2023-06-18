<?php

namespace App\Controller;

use App\MediaConvertFactory;
use Aws\MediaConvert\MediaConvertClient;
use Aws\Sdk;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AwsMediaConvertController
{
    #[Route("/media-convert/endpoints", name: 'media_convert.endpoints', methods: ['GET'])]
    public function listEndpoints(MediaConvertClient $mediaConvertClient): JsonResponse
    {
        $result = $mediaConvertClient->describeEndpoints([]);
        $endpointUrl = $result['Endpoints'][0]['Url'];

        return new JsonResponse(['result' => $result->toArray(), 'endpoint' => $endpointUrl]);
    }

    #[Route("/media-convert/create-job", name: 'media_convert.create_job', methods: ['POST'])]
    public function createJob(Request $request, Sdk $sdk, MediaConvertClient $mediaConvertClientDefault): JsonResponse
    {
        $params = json_decode($request->getContent(), true);

        $mediaConvertClient = MediaConvertFactory::factoryMediaConvert(
            $sdk,
            ['version' => $mediaConvertClientDefault->getApi()->getApiVersion()],
            $params['endpoint']
        );

        $result = $mediaConvertClient->createJob([
            "Role" => $params['iam_role_arn'],
            "Settings" => $this->buildJobSettings($params['source_file'], $params['destination_file']),
            "Queue" => $params['media_converter_queue_arn'],
//            "UserMetadata" => [
//                "Customer" => "Amazon"
//            ],
        ]);

        return new JsonResponse(['result' => $result->toArray()]);
    }

    private function buildJobSettings(string $sourceFile, string $destinationFile): array
    {
        return [
            'Inputs' => [
                [
                    'TimecodeSource' => 'ZEROBASED',
                    'VideoSelector' => [],
                    'AudioSelectors' => [
                        'Audio Selector 1' => [
                            'DefaultSelection' => 'DEFAULT',
                        ],
                    ],
                    'FileInput' => $sourceFile,
                ],
            ],
            'OutputGroups' => [
                [
                    'Name' => 'File Group',
                    'OutputGroupSettings' => [
                        'Type' => 'FILE_GROUP_SETTINGS',
                        'FileGroupSettings' => [
                            'Destination' => $destinationFile,
                        ],
                    ],
                    'Outputs' => [
                        [
                            'Preset' => 'System-Generic_Hd_Mp4_Av1_Aac_16x9_1280x720p_30Hz_1Mbps_Qvbr_Vq6',
                        ],
                    ],
                    'CustomName' => 'web',
                ],
            ],
            'TimecodeConfig' => [
                'Source' => 'ZEROBASED',
            ],
        ];
    }
}
