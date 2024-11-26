<?php
declare(strict_types=1);

namespace App\Services;

class CalendarServices
{
    public function parseInputWithIntegersAndComma(array $lines)
    {
        $finalArray = [];
        foreach ($lines as $key => $line) {
            $arrLine = explode(',', $line);
            foreach ($arrLine as $keyLine => $number) {
                $arrLine[$keyLine] = (int) $number;
            }
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    // a bc turns to ['a',' ','b','c']
    public function parseInputFromStringsToArray(array $lines)
    {
        $finalArray = [];

        foreach ($lines as $key => $line) {
            $arrLine = str_split($line);
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    // a bc turns to ['a', 'bc']
    public function parseInputFromStringsWithSpaceToArray(array $lines)
    {
        $finalArray = [];

        foreach ($lines as $key => $line) {
            $arrLine = explode(' ', $line);
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    public function parseInputFromStringsToIntArray(array $lines)
    {
        $finalArray = [];

        foreach ($lines as $key => $line) {
            $arrLine = array_map('intval', str_split($line));
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    public function getReversedGrid(array $grid): array
    {
        $fullArrayGrid = [];
        $reversedGrid = [];
        foreach ($grid as $key => $line) {
            $fullArrayGrid[$key] = str_split($line);
        }

        for ($i = 0; $i < count($fullArrayGrid[0]); ++$i) {
            $reversedGrid[$i] = implode('', array_column($fullArrayGrid, $i));
        }

        return $reversedGrid;
    }
}
