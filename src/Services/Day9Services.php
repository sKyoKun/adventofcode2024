<?php

namespace App\Services;

class Day9Services
{
    private array $fragmented = [];
    private array $compacted = [];

    public function fromDiskmapToFragmented(string $diskmap)
    {
        $commands = str_split($diskmap);
        $counter = 0;
        for($i = 0; $i <= count($commands)-1; $i+=2) {
            for($j = 0; $j < $commands[$i]; $j++) {
                $this->fragmented[] = $counter;
            }
            if (isset($commands[$i+1])) {
                for($k = 0; $k < $commands[$i+1]; $k++) {
                    $this->fragmented[] = '.';
                }
            }

            $counter++;
        }
    }

    public function compact()
    {
        $this->compacted = $this->fragmented;
        $reversedFragmented = array_reverse($this->fragmented, true);
        for ($i = count($reversedFragmented)-1; $i >= 0; $i--) {
            if ('.' === $reversedFragmented[$i]) {
                continue;
            }
            $firstDotKey = array_search('.', $this->compacted);
            $this->compacted[$firstDotKey] = $reversedFragmented[$i];
            $this->compacted[$i] = '.';

            if ($this->isSwapFinished()) {
                return;
            }
        }
    }

    public function isSwapFinished(): bool
    {
        $implode = implode('', $this->compacted);

        return 1 !== preg_match("/\.\d/", $implode);
    }

    public function calculateChecksum(): int
    {
        $checksum = 0;

        foreach ($this->compacted as $key => $value) {
            if ('.' === $value) {
                return $checksum;
            }
            $checksum += $key * $value;
        }

        return $checksum;
    }

    public function getChecksum(string $diskmap): int
    {
        $this->fromDiskmapToFragmented($diskmap);
        $this->compact();

        return $this->calculateChecksum();
    }
}
