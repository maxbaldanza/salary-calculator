<?php

namespace Tests\MBaldanza\Salary;

use \DateTimeImmutable;
use MBaldanza\Salary\StandardDateCalculator;

class StandardDateCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StandardDateCalculator
     */
    protected $standardDateCalculator;

    public function setUp()
    {
        $this->standardDateCalculator = new StandardDateCalculator();
    }

    public function testCalculateSalaryDayNotAWeekend()
    {
        $testDates = array(
            array('date' => '2016-01-18', 'expected' => '2016-02-29'),
            array('date' => '2016-02-01', 'expected' => '2016-03-31'),
            array('date' => '2016-04-30', 'expected' => '2016-05-31'),
        );

        foreach ($testDates as $testDate) {
            $date = new DateTimeImmutable($testDate['date']);
            $salaryDate = $this->standardDateCalculator->calculateDate($date);
            $this->assertInstanceOf(DateTimeImmutable::class, $salaryDate);
            $expectedDate = new DateTimeImmutable($testDate['expected']);
            $this->assertEquals($expectedDate, $salaryDate);
        }
    }

    public function testCalculateSalaryDateWeekend()
    {
        $testDates = array(
            array('date' => '2015-12-15', 'expected' => '2016-01-29'),
            array('date' => '2016-03-18', 'expected' => '2016-04-29'),
            array('date' => '2016-06-30', 'expected' => '2016-07-29'),
        );
        foreach ($testDates as $testDate) {
            $date = new DateTimeImmutable($testDate['date']);
            $salaryDate = $this->standardDateCalculator->calculateDate($date);
            $this->assertInstanceOf(DateTimeImmutable::class, $salaryDate);
            $expectedDate = new DateTimeImmutable($testDate['expected']);
            $this->assertEquals($expectedDate, $salaryDate);
        }
    }
}
