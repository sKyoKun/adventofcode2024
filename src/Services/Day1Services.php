<?php

declare(strict_types=1);

namespace App\Services;

class Day1Services
{
    public function getLists(array $lines): array
    {
        $listA = [];
        $listB = [];

        foreach ($lines as $line) {
            $explodedLine = explode('   ', $line);
            $listA[] = $explodedLine[0];
            $listB[] = $explodedLine[1];
        }

        return [$listA, $listB];
    }


    public function getDifference(array $lists): array
    {
        $listA = $lists[0];
        $listB = $lists[1];
        sort($listA);
        sort($listB);

        $distance = [];
        foreach ($listA as $key => $value) {
            $distance[] = abs($value - $listB[$key]);
        }

        return $distance;
    }

    public function getSimilarityScore(array $lists): int
    {
        $similarityScore = 0;
        $listA = $lists[0];
        $howManyTimes = array_count_values($lists[1]);

        foreach ($listA as $value) {
            $similarityScore += (int)$value * (isset($howManyTimes[$value]) ? $howManyTimes[$value] : 0);
        }

        return $similarityScore;
    }
}
