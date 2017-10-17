<?php

namespace Tests\MBaldanza\Salary;

use \DateTimeImmutable;
use MBaldanza\Salary\BonusDateCalculator;

class BonusDateCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BonusDateCalculator
     */
    protected $bonusDateCalculator;

    public function setUp()
    {
        $this->bonusDateCalculator = new BonusDateCalculator();
    }

    public function testCalculateBonusDayNotAWeekend()
    {
        $testDates = array(
            array('date' => '2015-12-31', 'expected' => '2016-01-15'),
            array('date' => '2016-03-15', 'expected' => '2016-04-15'),
            array('date' => '2016-05-01', 'expected' => '2016-06-15'),
            array('date' => '2016-06-30', 'expected' => '2016-07-15'),
        );

        foreach ($testDates as $testDate) {
            $date = new DateTimeImmutable($testDate['date']);
            $bonusDate = $this->bonusDateCalculator->calculateDate($date);
            $this->assertInstanceOf(DateTimeImmutable::class, $bonusDate);
            $expectedDate = new DateTimeImmutable($testDate['expected']);
            $this->assertEquals($expectedDate, $bonusDate);
        }
    }

    public function testCalculateBonusWeekend()
    {
        $testDates = array(
            array('date' => '2016-04-18', 'expected' => '2016-05-18'),
            array('date' => '2016-09-01', 'expected' => '2016-10-19'),
        );

        foreach ($testDates as $testDate) {
            $date = new DateTimeImmutable($testDate['date']);
            $bonusDate = $this->bonusDateCalculator->calculateDate($date);
            $this->assertInstanceOf(DateTimeImmutable::class, $bonusDate);
            $expectedDate = new DateTimeImmutable($testDate['expected']);
            $this->assertEquals($expectedDate, $bonusDate);
        }
    }
}
