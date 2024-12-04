<?php

namespace App\Services;

class Day4Services
{
    private const XMAS = 'XMAS';
    private const MAS = 'MAS';

    public function countXmas(array $grid): int
    {
        $count = 0;

        for ($x=0; $x < count($grid); $x++) {
            for ($y=0; $y < count($grid[$x]); $y++) {
                $count = $this->foundXmasLookingUpLeft($grid, $x, $y) ? $count+1 : $count;
                $count = $this->foundXmasLookingUpRight($grid, $x, $y) ? $count+1 : $count;
                $count = $this->foundXmasLookingUp($grid, $x, $y) ? $count+1 : $count;
                $count = $this->foundXmasLookingLeft($grid, $x, $y) ? $count+1 : $count;
                $count = $this->foundXmasLookingRight($grid, $x, $y) ? $count+1 : $count;
                $count = $this->foundXmasLookingDownLeft($grid, $x, $y) ? $count+1 : $count;
                $count = $this->foundXmasLookingDown($grid, $x, $y) ? $count+1 : $count;
                $count = $this->foundXmasLookingDownRight($grid, $x, $y) ? $count+1 : $count;
            }
        }

        return $count;
    }


    public function countMas(array $grid): int
    {
        $count = 0;

        for ($x=0; $x < count($grid); $x++) {
            for ($y=0; $y < count($grid[$x]); $y++) {
                if (
                    $grid[$x][$y] === 'A' &&
                    $this->foundMasLookingUpLeftDownRight($grid, $x, $y) &&
                    $this->foundMasLookingUpRightDownLeft($grid, $x, $y)
                ) {
                    $count++;
                }
            }
        }

        return $count;
    }

    private function foundMasLookingUpLeftDownRight(array $grid, int $x, int $y): bool
    {
        $currentWord = '';
        if (false === isset($grid[$x-1][$y-1]) || false === isset($grid[$x+1][$y+1])) {
            return false;
        }
        $currentWord.= $grid[$x-1][$y-1];
        $currentWord.= $grid[$x][$y];
        $currentWord.= $grid[$x+1][$y+1];

        if (self::MAS === $currentWord || self::MAS === strrev($currentWord)) {
            return true;
        }
        return false;
    }

    private function foundMasLookingUpRightDownLeft(array $grid, int $x, int $y): bool
    {
        $currentWord = '';
        if (false === isset($grid[$x-1][$y+1]) || false === isset($grid[$x+1][$y-1])) {
            return false;
        }
        $currentWord.= $grid[$x-1][$y+1];
        $currentWord.= $grid[$x][$y];
        $currentWord.= $grid[$x+1][$y-1];

        if (self::MAS === $currentWord || self::MAS === strrev($currentWord)) {
            return true;
        }
        return false;
    }

    private function foundXmasLookingUp(array $grid, int $x, int $y): bool
    {
        $currentWord = '';

        for ($line = $x; $line > $x-4; $line--) {
            if (false === $this->readLetter($grid, $currentWord,  $line, $y)) {
                return false;
            }
        }
        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }

    private function foundXmasLookingUpLeft(array $grid, int $x, int $y): bool
    {
        $currentWord = '';
        $currentY = $y;
        for ($line = $x; $line > $x-4; $line--) {
            if (false === $this->readLetter($grid, $currentWord,  $line, $currentY)) {
                return false;
            }
            $currentY--;
        }
        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }

    private function foundXmasLookingUpRight(array $grid, int $x, int $y): bool
    {
        $currentWord = '';
        $currentY = $y;
        for ($line = $x; $line > $x-4; $line--) {
            if (false === $this->readLetter($grid, $currentWord,  $line, $currentY)) {
                return false;
            }
            $currentY++;
        }
        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }
    private function foundXmasLookingLeft(array $grid, int $x, int $y): bool
    {
        $currentWord = '';

        for ($column = $y; $column > $y-4; $column--)
        {
            if (false === $this->readLetter($grid, $currentWord,  $x, $column)) {
                return false;
            }
        }
        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }

    private function foundXmasLookingRight(array $grid, int $x, int $y): bool
    {
        $currentWord = '';

        for ($column = $y; $column < $y+4; $column++)
        {
            if (false === $this->readLetter($grid, $currentWord,  $x, $column)) {
                return false;
            }
        }
        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }

    private function foundXmasLookingDownRight(array $grid, int $x, int $y): bool
    {
        $currentWord = '';
        $currentY = $y;
        for ($line = $x; $line < $x+4; $line++) {
            if (false === $this->readLetter($grid, $currentWord,  $line, $currentY)) {
                return false;
            }
            $currentY++;
        }

        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }

    private function foundXmasLookingDownLeft(array $grid, int $x, int $y): bool
    {
        $currentWord = '';
        $currentY = $y;
        for ($line = $x; $line < $x+4; $line++) {
            if (false === $this->readLetter($grid, $currentWord,  $line, $currentY)) {
                return false;
            }
            $currentY--;
        }

        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }

    private function foundXmasLookingDown(array $grid, int $x, int $y): bool
    {
        $currentWord = '';

        for ($line = $x; $line < $x+4; $line++) {
            if (false === $this->readLetter($grid, $currentWord,  $line, $y)) {
                return false;
            }
        }

        if (self::XMAS === $currentWord) {
            return true;
        }
        return false;
    }

    private function readLetter(array $grid, string &$currentWord, int $line, int $column): ?bool
    {
        if (false === isset($grid[$line][$column])) {
            return false;
        }

        $currentWord .= $grid[$line][$column];

        return null;
    }
}
