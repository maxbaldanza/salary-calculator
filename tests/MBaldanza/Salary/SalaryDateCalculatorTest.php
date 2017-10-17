<?php

namespace Tests\MBaldanza\Salary;

use MBaldanza\Salary\BonusDateCalculator;
use MBaldanza\Salary\SalaryDateCalculator;
use \DateTimeImmutable;

class SalaryDateCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SalaryDateCalculator
     */
    protected $salaryDateCalculator;

    public function setUp()
    {
        $this->salaryDateCalculator = new SalaryDateCalculator(
            $this->createMock(BonusDateCalculator::class)
        );
    }

    public function testCreateResults()
    {
        $numberOfMonths = 12;
        $results = $this->salaryDateCalculator->createResults($numberOfMonths);
        $this->assertEquals($numberOfMonths, count($results));
    }
}
