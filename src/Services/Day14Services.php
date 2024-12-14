<?php

namespace App\Services;

class Day14Services
{
    public function getRobotsPositionAndVelocity(array $lines): array
    {
        $robots = [];
        foreach ($lines as $key => $line) {
            $posVelocity = explode(' ', $line);
            $positions = [];
            $velocity = [];
            preg_match_all('#-?\d+#', $posVelocity[0], $positions);
            preg_match_all('#-?\d+#', $posVelocity[1], $velocity);
            $robots[$key]['position'] = $positions[0];
            $robots[$key]['velocity'] = $velocity[0];
        }

        return $robots;
    }

    public function calculateRobotPositionAfterIteration(
        array &$robots,
        int $robotId,
        int $iteration = 5,
        int $width = 11,
        int $height = 7
    ):void {
        $xPos = $robots[$robotId]['position'][0];
        $yPos = $robots[$robotId]['position'][1];

        $xVelocity = $robots[$robotId]['velocity'][0];
        $yVelocity = $robots[$robotId]['velocity'][1];

        $xValue = (($iteration * $xVelocity) + $xPos) % $width;
        $yValue = (($iteration * $yVelocity) + $yPos) % $height;
        if ($xValue < 0) {
            $xValue += $width;
        }
        if ($yValue < 0) {
            $yValue += $height;
        }

        $robots[$robotId]['finalPos'] = $xValue.'/'.$yValue;
    }

    public function calculateSafetyFactor($robots, $width, $height): int
    {
        $quandrant1 = 0;
        $quandrant2 = 0;
        $quandrant3 = 0;
        $quandrant4 = 0;

        foreach ($robots as $robot) {
            $finalPoses = explode('/', $robot['finalPos']);
            if ($finalPoses[0] < ($width-1)/2) {
                if ($finalPoses[1] < ($height-1)/2) {
                    $quandrant1++;
                } elseif($finalPoses[1] > ($height-1)/2) {
                    $quandrant3++;
                }
            } elseif ($finalPoses[0] > ($width-1)/2) {
                if ($finalPoses[1] < ($height-1)/2) {
                    $quandrant2++;
                } elseif($finalPoses[1] > ($height-1)/2) {
                    $quandrant4++;
                }
            }
        }

        return $quandrant1*$quandrant2*$quandrant3*$quandrant4;
    }
}
