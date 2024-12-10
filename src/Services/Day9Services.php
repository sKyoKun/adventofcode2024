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

    public function compactWithFileSize()
    {
        $this->compacted = $this->fragmented;
        $freeSpace = [];
        $files = [];

        // create spaces[pos] = length
        // and files[value] = [pos, length]
        foreach ($this->compacted as $pos => $value) {
            if ('.' !== $value) {
                if (false === array_key_exists($value, $files) || $value !== array_key_last($files)) {
                    $files[$value] = ['pos' => $pos, 'length' => 1];
                } else {
                    $files[$value]['length']++;
                }
            } else {
                // if we don't have the current pos in our freespace array and the last free space + its length is < pos
                // we create a new space
                if (empty ($freeSpace) || (false === array_key_exists($pos, $freeSpace)
                    && $pos !== ($freeSpace[array_key_last($freeSpace)] + array_key_last($freeSpace)))
                ) {
                    $freeSpace[$pos] = 1;
                } else {
                    $freeSpace[array_key_last($freeSpace)]++;
                }
            }
        }

        $reversedFiles = array_reverse($files, true);

        foreach ($reversedFiles as $value => $fileInfo) {
            foreach ($freeSpace as $pos => $freeLength) {
                // the space needs to be on the left of the file
                if ($fileInfo['length'] <= $freeLength && $pos < $fileInfo['pos']) {
                    for ($i = 0; $i < $fileInfo['length']; $i++) {
                        $this->compacted[$pos+$i] = $value;
                        $this->compacted[$fileInfo['pos']+$i] = '.';
                    }

                    // we remove the current space pos
                    unset($freeSpace[$pos]);
                    // create a new free spot at the new pos with the remaining length
                    $freeSpace[$pos + $fileInfo['length']] = $freeLength - $fileInfo['length'];
                    // we sort the keys so the new space is at the right place instead of at the end
                    ksort($freeSpace);

                    continue 2;
                }
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

    public function calculateChecksumWithFileSize(): int
    {
        $checksum = 0;

        foreach ($this->compacted as $key => $value) {
            if ('.' === $value) {
                continue;
            }
            $checksum += $key * $value;
        }

        return $checksum;
    }

    public function getChecksum(string $diskmap, bool $withFileSize = false): int
    {
        $this->fromDiskmapToFragmented($diskmap);

        if ($withFileSize) {
            $this->compactWithFileSize();

            return $this->calculateChecksumWithFileSize();
        }

        $this->compact();

        return $this->calculateChecksum();
    }
}
