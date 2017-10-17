<?php

namespace MBaldanza\Salary;

use \DateTimeImmutable;

class SalaryDateCalculator
{
    /**
     * @var DateTimeImmutable
     */
    private $startDate;

    /**
     * @var DateCalculator[]
     */
    private $dateCalculators;

    public function __construct(DateCalculator ...$dateCalculators)
    {
        $this->startDate = new DateTimeImmutable();
        $this->dateCalculators = $dateCalculators;
    }

    public function createResults(int $numberOfMonths): array
    {
        $processedDate = $this->startDate;
        $results = array();
        while ($numberOfMonths > 0) {
            $results[] = $this->processMonth($processedDate);

            $processedDate = $processedDate->modify('+1 month');
            $numberOfMonths--;
        }
        return $results;
    }

    private function processMonth(DateTimeImmutable $date): array
    {
        $month = $date->modify('+1 month');

        $result = [
            'month' => $month->format('m/Y'),
        ];

        foreach ($this->dateCalculators as $dateCalculator) {
            $result[] = $dateCalculator->calculateDate($month)->format('d-m-Y');
        }

        return $result;
    }
}
