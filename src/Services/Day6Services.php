<?php

namespace App\Services;

class Day6Services
{
    public const STARTING_POINT = '^';

    public function __construct(private CalendarServices $calendarServices)
    {
    }

    public function findStartingPoint(array &$grid)
    {
        foreach ($grid as $x => $row) {
            foreach ($row as $y => $point) {
                if (self::STARTING_POINT === $point) {
                    return [$x, $y];
                }
            }
        }

        return null;
    }

    public function test(array $grid): void
    {
        $this->calendarServices->rotateGridAntiClockwise($grid);
    }

    public function isEndOfGrid(array $grid, int $pointX, int $pointY): bool
    {
        if (false === isset($grid[$pointX][$pointY])) {
            return true;
        }

        return false;
    }

    public function walk(array $grid, int $startingPointX, int $startingPointY, array &$visited): void
    {
        while (false === $this->isEndOfGrid($grid, $startingPointX, $startingPointY) && '#' !== $grid[$startingPointX][$startingPointY]) {
            $visited[$startingPointX][$startingPointY] = 'X';
            $startingPointX = $startingPointX - 1;
        }
        if ($this->isEndOfGrid($grid, $startingPointX, $startingPointY)) {
            return;
        }

        $newX = count($grid[$startingPointY]) - 1 - $startingPointY ;
        $newY = $startingPointX + 1; // if we're on a #, we need the previous value

        $grid = $this->calendarServices->rotateGridAntiClockwise($grid);
        $visited = $this->calendarServices->rotateGridAntiClockwise($visited);

        $this->walk($grid, $newX, $newY, $visited);
    }

    public function countVisitedPoints(array $visited): int
    {
        $count = 0;
        foreach ($visited as $line) {
            foreach ($line as $point) {
                if('X' === $point) {
                    $count++;
                }
            }
        }

        return $count;
    }
}
