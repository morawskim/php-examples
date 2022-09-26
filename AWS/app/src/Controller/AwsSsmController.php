<?php

namespace App\Controller;

use Aws\Ssm\SsmClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AwsSsmController
{
    #[Route("/ssm/get-secret-parameter", name: 'ssm.get_secret_parameter', methods: ['GET'])]
    public function getSecretParameter(SsmClient $ssmClient): JsonResponse
    {
        $result = $ssmClient->getParameter([
            'Name' => '/sfdemo/terraform/foo',
            'WithDecryption' => true,
        ]);

        return new JsonResponse($result->toArray());
    }

    #[Route("/ssm/get-parameters", name: 'ssm.get_parameters', methods: ['GET'])]
    public function getParameters(SsmClient $ssmClient): JsonResponse
    {
        $result = $ssmClient->getParametersByPath([
            'Path' => '/sfdemo/terraform/',
            'WithDecryption' => true,
        ]);

        return new JsonResponse($result->toArray());
    }
}
