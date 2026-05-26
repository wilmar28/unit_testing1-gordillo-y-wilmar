<?php
// Ejercicio 2 — Tests de OrderService con Mocks

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

require_once __DIR__ . '/../../src/OrderService.php';

class OrderServiceTest extends TestCase
{
    private MockObject $inventoryMock;
    private MockObject $notificationMock;
    private OrderService $service;

    protected function setUp(): void
    {
        // Arrange — mocks de las dos dependencias
        $this->inventoryMock    = $this->createMock(IInventoryRepository::class);
        $this->notificationMock = $this->createMock(INotificationService::class);
        $this->service = new OrderService($this->inventoryMock, $this->notificationMock);
    }

    // ── Test 1: orden válida → reduce stock y envía notificación ──────────────

    public function test_placeOrder_ValidOrder_DecreasesStockAndSendsNotification(): void
    {
        // Arrange
        $this->inventoryMock
            ->method('getStock')
            ->willReturn(10);

        $this->inventoryMock
            ->expects($this->once())
            ->method('decreaseStock')
            ->with(42, 3);

        $this->notificationMock
            ->expects($this->once())
            ->method('sendConfirmation');

        // Act
        $order = $this->service->placeOrder(1, 42, 3);

        // Assert
        $this->assertEquals(1,           $order['userId']);
        $this->assertEquals(42,          $order['productId']);
        $this->assertEquals(3,           $order['quantity']);
        $this->assertEquals('confirmed', $order['status']);
        $this->assertArrayHasKey('orderId', $order);
    }

    // ── Test 2: stock insuficiente → lanza excepción, NO llama decreaseStock ──

    public function test_placeOrder_InsufficientStock_ThrowsException(): void
    {
        // Arrange — stock menor al solicitado
        $this->inventoryMock
            ->method('getStock')
            ->willReturn(2);

        // decreaseStock NUNCA debe llamarse
        $this->inventoryMock
            ->expects($this->never())
            ->method('decreaseStock');

        // Assert + Act
        $this->expectException(InsufficientStockException::class);
        $this->expectExceptionMessage('Stock insuficiente');

        $this->service->placeOrder(1, 42, 5);
    }

    // ── Test 3: cantidad inválida → lanza excepción, NO consulta inventario ───

    public function test_placeOrder_InvalidQuantity_ThrowsException(): void
    {
        // getStock NUNCA debe llamarse si la cantidad es inválida
        $this->inventoryMock
            ->expects($this->never())
            ->method('getStock');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La cantidad debe ser mayor a cero.');

        $this->service->placeOrder(1, 42, 0);
    }

    public function test_placeOrder_NegativeQuantity_ThrowsException(): void
    {
        $this->inventoryMock
            ->expects($this->never())
            ->method('getStock');

        $this->expectException(\InvalidArgumentException::class);

        $this->service->placeOrder(1, 42, -3);
    }

    // ── Test 4: en éxito → sendConfirmation llamado exactamente una vez ───────

    public function test_placeOrder_OnSuccess_NotificationServiceCalledOnce(): void
    {
        // Arrange
        $this->inventoryMock
            ->method('getStock')
            ->willReturn(20);

        // Assert — exactamente UNA notificación con userId y orderId correctos
        $this->notificationMock
            ->expects($this->once())
            ->method('sendConfirmation')
            ->with(5, $this->isType('int'));

        // Act
        $this->service->placeOrder(5, 10, 2);
    }
}
