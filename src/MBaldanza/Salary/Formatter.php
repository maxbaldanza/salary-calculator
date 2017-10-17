<?php

namespace MBaldanza\Salary;

interface Formatter
{
    public function export(array $data, array $headers = []): string;
}
