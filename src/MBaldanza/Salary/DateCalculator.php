<?php

namespace MBaldanza\Salary;

use DateTimeImmutable;

abstract class DateCalculator
{
    abstract public function calculateDate(DateTimeImmutable $date): DateTimeImmutable;

    protected function isWeekend(DateTimeImmutable $date): bool
    {
        $day = $date->format('N');
        return $day >= 6;
    }
}
