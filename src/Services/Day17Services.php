<?php

namespace App\Services;

class Day17Services
{
    public const COMBO_VALUES = [
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 'A',
        5 => 'B',
        6 => 'C',
    ];
    public const LITTERAL_VALUES = [
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
    ];

    private array $registers = [];

    private array $instructions = [];

    private array $printer = [];

    private ?int $currentInstructionKey;
    public function parseInstructions(array $lines): void
    {
        foreach ($lines as $line) {
            if (str_contains($line, 'Register'))
            {
                preg_match('#Register ([ABC]): (\d*)#', $line, $matches);
                $this->registers[$matches[1]] = (int)$matches[2];
            }
            if (str_contains($line, 'Program'))
            {
                $explodedLine = explode(':', $line);
                $explodedInstructions = explode(',', trim($explodedLine[1]));
                for ($i = 0; $i < count($explodedInstructions)-1; $i= $i+2) {
                    $this->instructions[] = [
                        'instruction' => (int) $explodedInstructions[$i],
                        'operand' => (int) $explodedInstructions[$i+1]
                    ];
                }
            }
        }
    }

    public function runProgram(): string
    {
        $this->currentInstructionKey = 0;
        while (
            null !== $this->currentInstructionKey
            && array_key_exists($this->currentInstructionKey,
            $this->instructions)
        ) {
            $instruction = $this->instructions[$this->currentInstructionKey]['instruction'];
            switch($this->instructions[$this->currentInstructionKey]['instruction']) {
                case 0:
                    $this->xdv('A', $this->instructions[$this->currentInstructionKey]['operand']);
                    break;
                case 1:
                    $this->bxl($this->instructions[$this->currentInstructionKey]['operand']);
                    break;
                case 2:
                    $this->bst($this->instructions[$this->currentInstructionKey]['operand']);
                    break;
                case 3:
                    $this->jnz($this->instructions[$this->currentInstructionKey]['operand']);
                    break;
                case 4:
                    $this->bxc($this->instructions[$this->currentInstructionKey]['operand']);
                    break;
                case 5:
                    $this->out($this->instructions[$this->currentInstructionKey]['operand']);
                    break;
                case 6:
                    $this->xdv('B', $this->instructions[$this->currentInstructionKey]['operand']);
                    break;
                case 7:
                    $this->xdv('C', $this->instructions[$this->currentInstructionKey]['operand']);
                    break;
            }

            if (3 !== $instruction) {
                $this->currentInstructionKey = $this->getNextKey($this->instructions, $this->currentInstructionKey);
            }
        }

        return $this->getOut();
    }

    public function xdv (string $letter, int $comboOperandKey):void
    {
        $comboOperandValue = $this->getComboValue($comboOperandKey);
        $denominator = pow(2, $comboOperandValue);
        $this->registers[$letter] = (int) floor($this->registers['A'] / $denominator);
    }

    public function bxl (int $litteralOperator): void
    {
        $this->registers['B'] = $this->registers['B'] ^ self::LITTERAL_VALUES[$litteralOperator];
    }

    public function bxc (int $litteralOperator): void
    {
        $this->registers['B'] = $this->registers['B'] ^ $this->registers['C'];
    }

    public function bst (int $comboOperandKey): void
    {
        $this->registers['B'] = $this->getComboValue($comboOperandKey) % 8;
    }

    public function out (int $comboOperandKey): void
    {
        $this->printer[] = $this->getComboValue($comboOperandKey) % 8;
    }

    public function jnz (int $litteralOperand): void
    {
        if (0 === $this->registers['A']) {
            $this->currentInstructionKey = $this->getNextKey($this->instructions, $this->currentInstructionKey);
        } else {
            $this->currentInstructionKey = self::LITTERAL_VALUES[$litteralOperand];
        }
    }

    private function getComboValue(int $comboOperandKey) {
        $comboOperandValue = self::COMBO_VALUES[$comboOperandKey];
        if (ctype_alpha($comboOperandValue)) {
            $comboOperandValue = $this->registers[$comboOperandValue];
        }

        return $comboOperandValue;
    }

    public function getOut(): string
    {
        return implode(',', $this->printer);
    }

    function getNextKey($array,$key){
        $keys = array_keys($array);
        $position = array_search($key, $keys);
        if (isset($keys[$position + 1])) {
            return $keys[$position + 1];
        }
        return null;
    }


    // for testing purpose
    public function getRegister(string $letter): int
    {
        return $this->registers[$letter];
    }

    public function setRegister(string $letter, $value): int
    {
        return $this->registers[$letter] = $value;
    }
}
