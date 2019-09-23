<?php

namespace App\Model;

class ArticleFilter
{
    /** @var string|null */
    private $name;

    /** @var DateRange|null */
    private $dateRange;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return DateRange|null
     */
    public function getDateRange(): ?DateRange
    {
        return $this->dateRange;
    }

    /**
     * @param DateRange|null $dateRange
     */
    public function setDateRange(?DateRange $dateRange): void
    {
        $this->dateRange = $dateRange;
    }
}
