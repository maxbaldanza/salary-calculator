<?php

namespace MBaldanza\Salary\Command;

use DateTimeImmutable;
use MBaldanza\Salary\BonusDateCalculator;
use MBaldanza\Salary\CsvFormatter;
use MBaldanza\Salary\SalaryDateCalculator;
use MBaldanza\Salary\StandardDateCalculator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SalaryCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('salary:export')
            ->setDescription('Export salaries')

            ->addOption('filename', 'f', InputOption::VALUE_REQUIRED, 'Filename to export payroll to', 'var/payroll.csv')
            ->addOption('date', null, InputOption::VALUE_OPTIONAL, 'Date to calculate salaries from')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getOption('filename');


        $salaryDateCalculator = new SalaryDateCalculator(
            $this->getDateFromInput($input),
            new BonusDateCalculator(),
            new StandardDateCalculator()
        );

        $results = $salaryDateCalculator->createResults(12);

        $csv = new CsvFormatter($filename);
        $csv->export($results, ['Month', 'Bonus', 'Salary']);

        $output->write("Output wrote to file: $filename");
    }

    private function getDateFromInput(InputInterface $input)
    {
        $date = $input->getOption('date');
        if (!$date) {
            return new DateTimeImmutable();
        }

        return new DateTimeImmutable($date);
    }
}
