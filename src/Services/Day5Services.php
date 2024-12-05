<?php

namespace App\Services;

class Day5Services
{
    public function parseSafetyProtocol(array $lines)
    {
        $rules = [];
        $updates = [];

        foreach ($lines as $line) {
            if (str_contains($line, '|')) {
                $explode = explode('|', $line);
                $rules[$explode[0]][] = $explode[1];
            } else if(str_contains($line, ',')) {
                $explode = explode(',', $line);
                $updates[] = $explode;
            }
        }

        return [$rules, $updates];
    }

    public function calculateSumMiddlePagesOfCorrectUpdates(array $updates, array $rules): int
    {
        $sum = 0;
        foreach ($updates as $update) {
            if ($this->isUpdateInRightOrder($update, $rules)) {
                $count = count($update);
                $middle = floor($count / 2);
                $sum += $update[$middle];
            }
        }

        return $sum;
    }

    public function calculateSumMiddlePagesOfIncorrectUpdates(array $updates, array $rules): int
    {
        $sum = 0;
        foreach ($updates as $update) {
            if ($this->isUpdateInRightOrder($update, $rules)) {
                continue;
            }
            $orderedUpdate = $this->getOrderedUpdate($update, $rules);
            $count = count($orderedUpdate);
            $middle = floor($count / 2);
            $sum += $orderedUpdate[$middle];
        }

        return $sum;
    }

    public function getOrderedUpdate(array $update, array $rules): array
    {
        $updateCopy = $update;

        usort($update, function($a, $b) use ($updateCopy, $rules) {
            return $this->pageAfterCount($a, $updateCopy, $rules) < $this->pageAfterCount($b, $updateCopy, $rules);
        });

        return $update;
    }

    public function pageAfterCount(int $number, array $update, array $rules): int
    {
        if (false === isset($rules[$number])) {
            return 0;
        }

        $diff = array_intersect($update, $rules[$number]);

        return count($diff);
    }

    public function isUpdateInRightOrder(array $update, array $rules): bool
    {
        $updateCopy = $update;

        $orderedUpdate = $this->getOrderedUpdate($update, $rules);

        return $orderedUpdate === $updateCopy;
    }
}
