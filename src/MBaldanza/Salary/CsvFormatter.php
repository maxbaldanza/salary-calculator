<?php

namespace MBaldanza\Salary;

use \SplFileObject;
use \Exception;

class CsvFormatter implements Formatter
{
    const DELIMITER = ',';
    const ENCLOSURE = '"';

    /**
     * @var SplFileObject
     */
    private $outputFile;

    /**
     * @var string
     */
    private $outputFilename;

    public function __construct(string $outputFilename)
    {
        $this->outputFilename = $outputFilename;
        $this->createFile();
    }

    private function createFile()
    {
        $this->outputFile = new SplFileObject($this->outputFilename, 'w+');
    }

    public function export(array $data, array $headers = []): string
    {
        $this->createFile();
        
        if ($headers) {
            $headers = $this->fillHeaders(count($data), $headers);
            $this->outputFile->fputcsv($headers, self::DELIMITER, self::ENCLOSURE);
        }
        
        foreach ($data as $d) {
            $this->outputFile->fputcsv($d, self::DELIMITER, self::ENCLOSURE);
        }
        
        return $this->getContent();
    }

    private function fillHeaders(int $numberOfColumns, array $headers)
    {
        if ($numberOfColumns === count($headers)) {
            return $headers;
        }

        $defaultValues = array_fill(0, $numberOfColumns, '');

        return $headers + $defaultValues;
    }

    private function getContent(): string
    {
        return file_get_contents($this->outputFilename);
    }
}
