<?php

namespace App\Controller;

use Aws\S3\S3Client;
use Faker\Factory;
use Mmo\Faker\PicsumProvider;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AwsS3
{
    #[Route("/s3/put-object", name: 's3.put_object', methods: ['GET'])]
    public function putObject(
        S3Client $s3Client,
        #[Autowire('%env(AWS_S3_BUCKET)%')]
        string $bucketName
    ): JsonResponse {
        $faker = Factory::create();
        $faker->addProvider(new PicsumProvider($faker));
        $path = $faker->picsum();

        $response = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key' => sprintf('/test/%s', basename($path)),

            // or Body - resource or string as content
            'SourceFile' => $path,

            'ACL' => 'public-read',
            'ServerSideEncryption' => 'AES256',
            'StorageClass' => 'STANDARD_IA',
            'CacheControl' => 'public, max-age=3600',
            'Tagging' => 'foo=bar&tag=value'
        ]);

        return new JsonResponse(['ObjectUrl' => $response->get('ObjectURL')]);
    }
}
