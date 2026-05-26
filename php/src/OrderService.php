<?php
// Ejercicio 2 — OrderService con inyección de dependencias

// ── Interfaces ────────────────────────────────────────────────────────────────

interface IInventoryRepository
{
    public function getStock(int $productId): int;
    public function decreaseStock(int $productId, int $quantity): void;
}

interface INotificationService
{
    public function sendConfirmation(int $userId, int $orderId): void;
}

// ── Excepción personalizada ────────────────────────────────────────────────────

class InsufficientStockException extends \RuntimeException
{
    public function __construct(int $productId, int $requested, int $available)
    {
        parent::__construct(
            "Stock insuficiente para producto $productId. " .
            "Solicitado: $requested, Disponible: $available."
        );
    }
}

// ── Servicio ───────────────────────────────────────────────────────────────────

class OrderService
{
    private int $nextOrderId = 1;

    public function __construct(
        private IInventoryRepository $inventory,
        private INotificationService $notification
    ) {}

    public function placeOrder(int $userId, int $productId, int $quantity): array
    {
        // Validación de cantidad
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('La cantidad debe ser mayor a cero.');
        }

        // Consultar stock disponible
        $stock = $this->inventory->getStock($productId);

        // Verificar stock suficiente
        if ($stock < $quantity) {
            throw new InsufficientStockException($productId, $quantity, $stock);
        }

        // Reducir inventario
        $this->inventory->decreaseStock($productId, $quantity);

        // Generar orden
        $orderId = $this->nextOrderId++;
        $order = [
            'orderId'   => $orderId,
            'userId'    => $userId,
            'productId' => $productId,
            'quantity'  => $quantity,
            'status'    => 'confirmed',
        ];

        // Enviar notificación al usuario
        $this->notification->sendConfirmation($userId, $orderId);

        return $order;
    }
}
