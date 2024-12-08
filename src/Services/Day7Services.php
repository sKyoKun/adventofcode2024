<?php

namespace App\Services;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class Day7Services
{
    public const OPERATORS = ['+', '*', '||'];

    public function getResultsAndOperands(array $lines): array
    {
        $operations = [];
        foreach ($lines as $line) {
            $explodedLine = explode(':', $line);
            $numbers = explode(' ', trim($explodedLine[1]));
            $operations[$explodedLine[0]] = $numbers;
        }

        return $operations;
    }

    public function tryDifferentOperations(array $numbers, bool $withPipes)
    {
        $firstNumber = $numbers[0];
        array_shift($numbers);
        $differentPossibilities = [$firstNumber];
        foreach ($numbers as $number) {
            foreach ($differentPossibilities as $key => $differentPossibility) {
                foreach (self::OPERATORS as $operator) {
                    unset($differentPossibilities[$key]);
                    if ($operator === '+') {
                        $differentPossibilities[] = $differentPossibility+$number;
                    } elseif ($operator === '*') {
                        $differentPossibilities[] = $differentPossibility*$number;
                    } else {
                        if ($withPipes) {
                            $differentPossibilities[] = intval($differentPossibility.$number) ;
                        }
                    }
                }
            }
        }

        return $differentPossibilities;
    }

    public function getTotalCalibrationResult(array $lines, bool $withPipes = false): int
    {
        $validResults = [];
        foreach ($lines as $result => $numbers) {
            $differentPossibilities = $this->tryDifferentOperations($numbers, $withPipes);
            foreach ($differentPossibilities as $possibility) {
                if ($result === $possibility && false === in_array($result, $validResults)) {
                    $validResults[] = $result;
                }
            }
        }

        return array_sum($validResults);
    }
}
