<?php
// Paso 1 — Función simple
// Funciones puras sin clases ni dependencias externas

function add(int $a, int $b): int
{
    return $a + $b;
}

function divide(int $a, int $b): float
{
    if ($b === 0) {
        throw new \InvalidArgumentException('No se puede dividir entre cero.');
    }
    return $a / $b;
}
