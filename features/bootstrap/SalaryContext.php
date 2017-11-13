<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use MBaldanza\Console\Application;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Tester\CommandTester;

class SalaryContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var CommandTester
     */
    private $commandTester;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $filename;

    public function __construct()
    {
        $this->application = new Application('test');
    }

    /**
     * @Given the date is :date
     */
    public function theDateIs(string $date)
    {
        $this->date = $date;
    }

    /**
     * @Given the filename is :filename
     */
    public function theFilenameIs(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @When I run :commandName command
     */
    public function iRunCommand(string $commandName)
    {
        $command = $this->application->getCommand($commandName);

        $this->commandTester = new CommandTester($command);

        $params = [];
        if ($this->filename) {
            $params['--filename'] = $this->filename;
        }

        if ($this->date) {
            $params['--date'] = $this->date;
        }

        $this->commandTester->execute(
            array_merge(
                [
                    'command'  => $command->getName(),
                ],
                $params
            )
        );
    }

    /**
     * @Then I should see :output
     */
    public function iShouldSee($output)
    {
        Assert::assertEquals($output, $this->commandTester->getDisplay());
    }

    /**
     * @Then the file :filename should contain:
     */
    public function theFileShouldContain(string $filename, PyStringNode $contents)
    {
        Assert::assertEquals((string) $contents, trim(file_get_contents($filename)));
    }
}
