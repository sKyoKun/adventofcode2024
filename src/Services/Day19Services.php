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
            if(0 < $nbValidPattern) {
                $validDesigns++;
            }
        }

        return $validDesigns;
    }

    public function countTotalPossibleDesigns($towels, $designs)
    {
        foreach ($designs as $design) {
            $this->isValidDesign($towels, $design, $design);
        }

        return array_sum($this->numberOfValidPatterns);
    }

    public function isValidDesign($towels, $originalDesign, $design)
    {
        if ($design === $originalDesign) {
            $this->numberOfValidPatterns[$originalDesign] = 0;
        }

        // it's the end of the design, it's a valid one
        if ('' === $design) {
            $this->numberOfValidPatterns[$originalDesign]++;
            $this->cache[$design] = true;
            return;
        }

        if (isset($this->cache[$design])) {
            if ($this->cache[$design] === true) {
                $this->numberOfValidPatterns[$originalDesign]++;
            }
            return;
        }

        foreach ($towels as $towel) {
            if (str_starts_with($design, $towel))
            {
                $newDesign = substr($design, strlen($towel));
                $this->isValidDesign($towels, $originalDesign, $newDesign);
            }
        }
    }
}
