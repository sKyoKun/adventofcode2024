<?php

namespace App\Services;

class Day10Services
{
    private array $trailHeads = [];

    private array $passedCoordForTrail = [];

    public function searchTrailHeads(array $grid)
    {
        for($x = 0; $x < count($grid); $x++) {
            $trailHeads = array_keys($grid[$x], 0);
            if (false === empty($trailHeads)) {
                foreach($trailHeads as $y) {
                    $this->trailHeads[$x.'/'.$y] = 0;
                }
            }
        }
    }

    public function calculateScore(array $grid): int
    {
        foreach($this->trailHeads as $head => $count) {
            $trailHeadCoord = explode('/', $head);
            $this->passedCoordForTrail[$head][] = $head;
            $this->walkPath($grid, $head, $trailHeadCoord[0], $trailHeadCoord[1]);
        }

        return array_sum($this->trailHeads);
    }

    public function calculateRating(array $grid): int
    {
        foreach($this->trailHeads as $head => $count) {
            $trailHeadCoord = explode('/', $head);
            $this->passedCoordForTrail[$head][] = $head;
            $this->walkPath($grid, $head, $trailHeadCoord[0], $trailHeadCoord[1], 0, false);
        }

        return array_sum($this->trailHeads);
    }

    public function walkPath(array $grid, string $head, int $currentX, int $currentY, int $currentVal = 0, bool
    $countDistinct = true)
    {
        $valToSearch = $currentVal+1;
        // walk up
        $nextX = $currentX-1;
        $nextY = $currentY;
        $this->walk($grid, $head, $nextX, $nextY, $valToSearch, $countDistinct);

        // walk right
        $nextX = $currentX;
        $nextY = $currentY+1;
        $this->walk($grid, $head, $nextX, $nextY, $valToSearch, $countDistinct);

        // walk down
        $nextX = $currentX+1;
        $nextY = $currentY;
        $this->walk($grid, $head, $nextX, $nextY, $valToSearch, $countDistinct);

        // walk left
        $nextX = $currentX;
        $nextY = $currentY-1;
        $this->walk($grid, $head, $nextX, $nextY, $valToSearch, $countDistinct);
    }


    public function walk(
        array $grid,
        string $head,
        int $nextX,
        int $nextY,
        int $valToSearch,
        bool $countDistinct
    ) {
        if (isset($grid[$nextX][$nextY]) && ($valToSearch === $grid[$nextX][$nextY])) {
            $coordPoint = $nextX.'/'.$nextY;
            if (false === in_array($coordPoint, $this->passedCoordForTrail[$head])) {
                if (true === $countDistinct) {
                    $this->passedCoordForTrail[$head][] = $coordPoint;
                }
                if (9 === $valToSearch) {
                    $this->trailHeads[$head] = $this->trailHeads[$head] + 1;
                } else {
                    $this->walkPath($grid, $head, $nextX, $nextY, $valToSearch, $countDistinct);
                }
            }
        }
    }
}
