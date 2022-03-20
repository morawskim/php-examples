<?php

namespace App\Report\Dto;

class ReportRowDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public \DateTimeInterface $birthDay,
        public string $city,
        public string $country
    ) {
    }
}
