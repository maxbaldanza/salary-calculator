<?php

namespace MBaldanza\Salary;

use DateTimeImmutable;

class BonusDateCalculator extends DateCalculator
{
    public function calculateDate(DateTimeImmutable $date): DateTimeImmutable
    {
        $nextMonth = $date->modify('+1 month');
        $payDate = $nextMonth->setDate($nextMonth->format('Y'), $nextMonth->format('m'), 15);

        if ($this->isWeekend($payDate)) {
            $payDate = $payDate->modify('next wednesday');
        }

        return $payDate;
    }
}
