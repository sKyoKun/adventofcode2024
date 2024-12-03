<?php

namespace App\Services;

class Day3Services
{
    public function getMulOperations(array $corruptedData): array
    {
        $mulOperations = [];

        foreach ($corruptedData as $line) {
            preg_match_all('#(mul\([\d]{1,3},[\d]{1,3}\))#', $line, $matches);
            $mulOperations[] = $matches[1];
        }

        $mulOperations = array_merge(...$mulOperations);

        return $mulOperations;
    }

    public function multiplyOperationsValues(array $mulOperations): int
    {
        $total = 0;
        foreach ($mulOperations as $operation) {
            $operands = [];
            preg_match('#mul\(([\d]{1,3}),([\d]{1,3})\)#', $operation, $operands);

            $total += $operands[1] * $operands[2];
        }

        return $total;
    }

    public function sanitizeStrings(array $corruptedData): array
    {
        $sanitizedData = [];
        $wholeString = '';

        // the input should be considered as ONE string and not be split in multiple lines
        foreach ($corruptedData as $line) {
            $wholeString.= $line;
        }

        $sanitizedData[] = preg_replace('/don\'t\(\)[\s\S]+?do\(\)/', '', $wholeString);

        return $sanitizedData;
    }
}
