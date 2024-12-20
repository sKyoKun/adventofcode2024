<?php

namespace App\Services;

class Day19Services
{
    private array $cache = [];

    private array $numberOfValidPatterns = [];

    public function countValidDesigns($towels, $designs)
    {
        $validDesigns = 0;
        foreach ($designs as $design) {
            $this->isValidDesign($towels, $design, $design);
        }

        foreach ($this->numberOfValidPatterns as $nbValidPattern) {
            if (0 < $nbValidPattern) {
                $validDesigns++;
            }
        }

        return $validDesigns;
    }

    public function countTotalPossibleDesigns($towels, $designs)
    {
        $totalDesigns = 0;
        foreach ($designs as $design) {
            $totalDesigns += $this->isValidDesign($towels, $design, $design);
        }

        return $totalDesigns;
    }

    public function isValidDesign($towels, $originalDesign, $design): int
    {
        if ($design === $originalDesign) {
            $this->numberOfValidPatterns[$originalDesign] = 0;
        }

        // it's the end of the design, it's a valid one
        if ('' === $design) {
            $this->numberOfValidPatterns[$originalDesign]++; // for part1
            return 1 ;
        }

        if (isset($this->cache[$design])) {
            if (0 < $this->cache[$design]) { // for part1
                $this->numberOfValidPatterns[$originalDesign]++;
            }
            return $this->cache[$design];
        }

        $found = 0;
        foreach ($towels as $towel) {
            if (str_starts_with($design, $towel))
            {
                $newDesign = substr($design, strlen($towel));
                $found += $this->isValidDesign($towels, $originalDesign, $newDesign);
            }
        }

        $this->cache[$design] = $found;
        return $found ;
    }
}
