<?php

namespace App\Services;

class Day8Services
{
    private array $characterPos = [];
    private array $locations;

    public function getCountLocations(array $grid, bool $onlyOnce = true): int
    {
        $this->locations = $grid;
        $this->getCharacterPos($grid);
        foreach($this->characterPos as $antennas) {
            $this->computeLocationForCharacter($antennas, $onlyOnce);
        }

        return $this->countLocations();
    }

    public function getCharacterPos(array $grid): void
    {
        for($i = 0; $i < count($grid); $i++) {
            for ($j = 0; $j < count($grid[$i]); $j++) {
                if ('.' !== $grid[$i][$j]) {
                    $this->characterPos[$grid[$i][$j]][] = $i.'/'.$j;
                }
            }
        }
    }

    public function computeLocationForCharacter(array $coordinates, bool $onlyOnce)
    {
        for($i=0; $i<count($coordinates); $i++) {
            for($j=0; $j<count($coordinates); $j++) {
                if ($i === $j) {
                    continue;
                }
                $coord1 = explode('/', $coordinates[$i]);
                $coord2 = explode('/', $coordinates[$j]);

                $distanceX = $coord2[0] - $coord1[0];
                $distanceY = $coord2[1] - $coord1[1];

                $newX = $coord2[0] + $distanceX;
                $newY = $coord2[1] + $distanceY;

                if ($onlyOnce) {
                    if ($this->isInBound($newX, $newY)) {
                        $this->locations[$newX][$newY] = '#';
                    }
                } else {
                    if (1 === count($coordinates)) {
                        return;
                    }
                    $this->locations[$coord1[0]][$coord1[1]] = '#'; // add current position
                    while ($this->isInBound($newX, $newY)) {
                        $this->locations[$newX][$newY] = '#';
                        $newX = $newX + $distanceX;
                        $newY = $newY + $distanceY;
                    }
                }
            }
        }
    }

    public function isInBound(int $x, int $y): bool
    {
        return ($x >= 0 && $y >= 0 && $x <= count($this->locations) -1 && $y <= count($this->locations) -1) ;

    }

    public function countLocations(): int
    {
        $count = 0;
        for($i=0; $i<count($this->locations); $i++) {
            for ($j = 0; $j < count($this->locations[$i]); $j++) {
                if ($this->locations[$i][$j] === '#') {
                    $count++;
                }
            }
        }

        return $count;
    }
}
