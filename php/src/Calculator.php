<?php
// Paso 2 — Clase Calculator con estado interno e historial

class Calculator
{
    private array $history = [];

    public function add(float $a, float $b): float
    {
        $result = $a + $b;
        $this->history[] = "$a + $b = $result";
        return $result;
    }

    public function subtract(float $a, float $b): float
    {
        $result = $a - $b;
        $this->history[] = "$a - $b = $result";
        return $result;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function clearHistory(): void
    {
        $this->history = [];
    }
}
