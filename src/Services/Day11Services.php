<?php

namespace App\Services;

class Day11Services
{
    public function getStones(string $line): array
    {
        return explode(" ", $line);
    }

    public function blink(array $stones): array
    {
        $result = [];
        foreach ($stones as $stone) {
            $result = array_merge($result, $this->processStone($stone));
        }

        return $result;
    }

    public function processStone(string $stone): array
    {
        $newStones = [];
        if ('0' === $stone) {
            $newStones[] = '1';
        } elseif (0 === strlen($stone) % 2) {
            $firstStone = substr($stone, 0, (strlen($stone)/2));
            $secondStone = substr($stone,  -((strlen($stone)/2)));
            $newStones[] = (0 === intval($firstStone)) ? '0' :  ltrim($firstStone, '0');
            $newStones[] = (0 === intval($secondStone)) ? '0' :  ltrim($secondStone, '0');
        } else {
            $newStones[] = ''.(intval($stone) * 2024);
        }

        return $newStones;
    }

    public function getStonesAfterblinks(array $initialStones, int $blinkCount = 25)
    {
        $count = 1;
        $stones = $initialStones;
        while ($count <= $blinkCount) {
            $stones = $this->blink($stones);
            $count++;
        }

        return $stones;
    }
}
