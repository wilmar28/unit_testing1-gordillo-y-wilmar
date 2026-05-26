<?php
// Paso 1 — Tests de funciones simples

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/MathHelper.php';

class MathHelperTest extends TestCase
{
    public function test_add_returns_correct_sum(): void
    {
        // Arrange
        $a = 2;
        $b = 3;
        // Act
        $result = add($a, $b);
        // Assert
        $this->assertEquals(5, $result);
    }

    public function test_add_negative_numbers(): void
    {
        $this->assertEquals(-5, add(-1, -4));
    }

    public function test_add_zero_returns_same_number(): void
    {
        $this->assertEquals(7, add(0, 7));
    }

    public function test_divide_returns_float(): void
    {
        $this->assertEquals(2.5, divide(5, 2));
    }

    public function test_divide_exact_result(): void
    {
        $this->assertEquals(5.0, divide(10, 2));
    }

    public function test_divide_by_zero_throws_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No se puede dividir entre cero.');
        divide(10, 0);
    }
}
