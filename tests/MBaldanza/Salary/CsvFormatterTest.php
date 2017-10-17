<?php

namespace Tests\MBaldanza\Salary;

use MBaldanza\Salary\CsvFormatter;

class CsvFormatterTest extends \PHPUnit_Framework_TestCase
{
    const TEST_FILENAME = 'testFilename.txt';

    public function testCreateFileErrorWhenNoFilename()
    {
        $this->expectException('RuntimeException');
        new CsvFormatter('');
    }

    public function testEmptyHeaders()
    {
        $csv = new CsvFormatter(self::TEST_FILENAME);
        $expectedCsv = "04/2016,15-04-2016,29-04-2016
05/2016,18-05-2016,31-05-2016
06/2016,15-06-2016,30-06-2016
";
        $testData = $this->getTestData();
        $content = $csv->export($testData);
        $this->assertEquals($expectedCsv, $content);
    }

    public function testOutputHeaders()
    {
        $headers = ['Year', 'Bonus', 'Salary'];
        $csv = new CsvFormatter(self::TEST_FILENAME);
        $expectedCsv = "Year,Bonus,Salary
04/2016,15-04-2016,29-04-2016
05/2016,18-05-2016,31-05-2016
06/2016,15-06-2016,30-06-2016
";
        $testData = $this->getTestData();
        $content = $csv->export($testData, $headers);
        $this->assertEquals($expectedCsv, $content);
    }

    public function testItAddsEmptyHeaders()
    {
        $headers = ['Year'];
        $csv = new CsvFormatter(self::TEST_FILENAME);
        $expectedCsv = "Year,,
04/2016,15-04-2016,29-04-2016
05/2016,18-05-2016,31-05-2016
06/2016,15-06-2016,30-06-2016
";
        $testData = $this->getTestData();
        $content = $csv->export($testData, $headers);
        $this->assertEquals($expectedCsv, $content);
    }

    /**
     * Define our test data
     * @return array
     */
    private function getTestData()
    {
        return [
            [
                'month' => '04/2016',
                'bonusDate' => '15-04-2016',
                'salaryDate' => '29-04-2016',
            ],
            [
                'month' => '05/2016',
                'bonusDate' => '18-05-2016',
                'salaryDate' => '31-05-2016',
            ],
            [
                'month' => '06/2016',
                'bonusDate' => '15-06-2016',
                'salaryDate' => '30-06-2016',
            ]
        ];
    }
}
