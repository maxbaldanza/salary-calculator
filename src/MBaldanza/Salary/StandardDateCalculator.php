<?php

namespace MBaldanza\Salary;

use DateTimeImmutable;

class StandardDateCalculator extends DateCalculator
{
    public function calculateDate(DateTimeImmutable $date): DateTimeImmutable
    {
        $payDate = $date->modify('+1 month');
        $payDate = $payDate->modify('last day of this month');

        if ($this->isWeekend($payDate)) {
            $payDate = $payDate->modify('last weekday');
        }

        return $payDate;
    }
}
