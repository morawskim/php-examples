<?php

namespace App\Report\Provider;

use App\Report\Dto\ReportRowDto;
use App\Report\ReportDataProviderInterface;
use Faker\Factory;

class RandomDataWithDelayProvider implements ReportDataProviderInterface
{
    public function __construct(private int $numbOfRowsToGenerate = 100_000, private int $delay = 0)
    {
    }

    public function getData(): iterable
    {
        $faker = Factory::create();

        for ($i = 0; $i < $this->numbOfRowsToGenerate; $i++) {
            usleep($this->delay);
            yield new ReportRowDto(
                $faker->firstName(),
                $faker->lastName(),
                $faker->dateTimeBetween('-80 years'),
                $faker->city(),
                $faker->country()
            );
        }
    }
}
