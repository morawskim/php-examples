<?php

namespace App\Controller;

use Aws\Exception\AwsException;
use Aws\SecretsManager\SecretsManagerClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AwsSecretManagerController
{
    #[Route("/secret-manager/get-secret-value", name: 'secret-manager.get_secret_value', methods: ['GET'])]
    public function getSecretValue(SecretsManagerClient $secretsManagerClient): JsonResponse
    {
        try {
            $result = $secretsManagerClient->getSecretValue([
                'SecretId' => 'sfdemo/terraform/foo',
            ]);

            // Decrypts secret using the associated KMS CMK.
            // Depending on whether the secret is a string or binary, one of these fields will be populated.
            $secret = $result['SecretString'] ?? base64_decode($result['SecretBinary']);

            return new JsonResponse(['decrypted_secret' => $secret]);
        } catch (AwsException $e) {
            $error = $e->getAwsErrorCode();
            if ('DecryptionFailureException' === $error) {
                // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ('InternalServiceErrorException' === $error) {
                // An error occurred on the server side.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ('InvalidParameterException' === $error) {
                // You provided an invalid value for a parameter.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ('InvalidRequestException' === $error) {
                // You provided a parameter value that is not valid for the current state of the resource.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }
            if ('ResourceNotFoundException' === $error) {
                // We can't find the resource that you asked for.
                // Handle the exception here, and/or rethrow as needed.
                throw $e;
            }

            throw $e;
        }
    }
}
