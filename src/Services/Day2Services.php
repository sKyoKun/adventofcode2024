<?php

namespace App\Services;

class Day2Services
{
    private const MIN_DISTANCE = 1;
    private const MAX_DISTANCE = 3;

    public function getReports(array $lines): array
    {
        $reports = [];
        foreach ($lines as $line) {
            $lineExploded = explode(' ', $line);
            $reports[] = $lineExploded;
        }

        return $reports;
    }

    public function getSafeReports(array $lines, bool $withTolerance = false): int
    {
        $safeReports = 0;

        foreach ($lines as $key => $report) {
            $isSafeReport = $this->isSafeReport($report);
            if ($isSafeReport) {
                $safeReports += 1;

                continue;
            }

            if ($withTolerance) {
                for ($i = 0; $i < count($report); $i++) {
                    $tempReport = $report;
                    unset($tempReport[$i]);
                    $newReport = array_values($tempReport);
                    if ($this->isSafeReport($newReport)) {
                        $safeReports += 1;

                        continue 2;
                    }
                }
            }

        }
        return $safeReports;
    }


    public function isSafeReport(array $report): bool {
        $isIncreasing = true;
        $isDecreasing = true;
        $isDistanceValid = true;

        for($i = 0; $i < (count($report)-1); $i++) {
            $distance = $this->getDistance((int) $report[$i], (int) $report[$i+1]);
            if (false === $this->isDistanceValid($distance)) {
                $isDistanceValid = false;
            }

            // if both isDecreasing && isIncreasing are false then the suite goes both ways
            if (0 < $distance) {
                $isDecreasing = false;
            } elseif (0 > $distance) {
                $isIncreasing = false;
            }
        }

        return $isDistanceValid && ($isIncreasing || $isDecreasing);
    }

    public function getDistance(int $value1, int $value2): int
    {
        return $value1 - $value2;
    }

    public function isDistanceValid(int $distance): bool
    {
        return abs($distance) >= self::MIN_DISTANCE && abs($distance) <= self::MAX_DISTANCE;
    }
}
