<?php

namespace App\Services;

class Day12Services
{
    private array $grid = [];
    private array $processedCoordinates = [];
    private array $regions = [];
    public function calculateTotalPrice(array $grid): int
    {
        $price = 0;

        $this->grid = $grid;
        for ($x = 0; $x < count($grid); $x++) {
            for ($y = 0; $y < count($grid[$x]); $y++) {
                $coordinates = $x.'/'.$y;
                if (false === in_array($coordinates, $this->processedCoordinates)) {
                    $plantIndex = 0;
                    if (isset($this->regions[$grid[$x][$y]])) {
                        $plantIndex = count($this->regions[$grid[$x][$y]]);
                    }
                    $this->processPlot($x, $y, $grid[$x][$y], $plantIndex);
                }
            }
        }

        foreach ($this->regions as $plant) {
            foreach ($plant as $region) {
                $price += count($region['coordinates']) * $region['fences'];
            }
        }

        return $price;
    }

    public function processPlot(int $x, int $y, string $plant, int $currentPlantIndex = 0)
    {
        if (false === isset($this->regions[$plant][$currentPlantIndex]['fences'])) {
            $this->regions[$plant][$currentPlantIndex]['fences'] = 0;
        }

        $this->processedCoordinates[] = $x.'/'.$y;
        $this->regions[$plant][$currentPlantIndex]['coordinates'][] = $x.'/'.$y;
        // look up
        $newX = $x-1;
        $newY = $y;
        $newCoordinates = $newX.'/'.$newY;
        if (false === in_array($newCoordinates, $this->regions[$plant][$currentPlantIndex]['coordinates'])) {
            if (false === isset($this->grid[$newX][$newY]) || $plant !== $this->grid[$newX][$newY]) {
                $this->regions[$plant][$currentPlantIndex]['fences']++;
            } else {
                $this->processPlot($newX, $newY, $plant, $currentPlantIndex);
            }
        }

        // look right
        $newX = $x;
        $newY = $y+1;
        $newCoordinates = $newX.'/'.$newY;
        if (false === in_array($newCoordinates, $this->regions[$plant][$currentPlantIndex]['coordinates'])) {
            if (false === isset($this->grid[$newX][$newY]) || $plant !== $this->grid[$newX][$newY]) {
                $this->regions[$plant][$currentPlantIndex]['fences']++;
            } else {
                $this->processPlot($newX, $newY, $plant, $currentPlantIndex);
            }
        }

        // look down
        $newX = $x+1;
        $newY = $y;
        $newCoordinates = $newX.'/'.$newY;
        if (false === in_array($newCoordinates, $this->regions[$plant][$currentPlantIndex]['coordinates'])) {
            if (false === isset($this->grid[$newX][$newY]) || $plant !== $this->grid[$newX][$newY]) {
                $this->regions[$plant][$currentPlantIndex]['fences']++;
            } else {
                $this->processPlot($newX, $newY, $plant, $currentPlantIndex);
            }
        }

        // look left
        $newX = $x;
        $newY = $y-1;
        $newCoordinates = $newX.'/'.$newY;
        if (false === in_array($newCoordinates, $this->regions[$plant][$currentPlantIndex]['coordinates'])) {
            if (false === isset($this->grid[$newX][$newY]) || $plant !== $this->grid[$newX][$newY]) {
                $this->regions[$plant][$currentPlantIndex]['fences']++;
            } else {
                $this->processPlot($newX, $newY, $plant, $currentPlantIndex);
            }
        }
    }
}
