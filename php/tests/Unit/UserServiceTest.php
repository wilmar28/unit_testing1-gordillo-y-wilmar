<?php
// Paso 4 — Tests con Mocks (createMock)

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

require_once __DIR__ . '/../../src/UserService.php';

class UserServiceTest extends TestCase
{
    private MockObject $repositoryMock;
    private UserService $service;

    protected function setUp(): void
    {
        // createMock() genera un doble del contrato (interfaz)
        $this->repositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->service = new UserService($this->repositoryMock);
    }

    public function test_register_saves_new_user(): void
    {
        // Arrange — el mock devuelve null (email no existe)
        $this->repositoryMock
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);

        $this->repositoryMock
            ->expects($this->once())
            ->method('save')
            ->willReturn(true);

        // Act
        $user = $this->service->register('nuevo@ejemplo.com', 'Secret123');

        // Assert
        $this->assertEquals('nuevo@ejemplo.com', $user['email']);
        $this->assertEquals('user', $user['role']);
        $this->assertTrue(password_verify('Secret123', $user['password']));
    }

    public function test_register_throws_when_email_already_exists(): void
    {
        // Arrange — simula que el email ya existe
        $this->repositoryMock
            ->method('findByEmail')
            ->willReturn(['id' => 1, 'email' => 'existente@ejemplo.com']);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('ya está registrado');

        $this->service->register('existente@ejemplo.com', 'Secret123');
    }

    public function test_register_does_not_call_save_when_email_exists(): void
    {
        // Arrange — email duplicado
        $this->repositoryMock
            ->method('findByEmail')
            ->willReturn(['id' => 1, 'email' => 'existente@ejemplo.com']);

        // save() NUNCA debe llamarse si el email ya existe
        $this->repositoryMock
            ->expects($this->never())
            ->method('save');

        try {
            $this->service->register('existente@ejemplo.com', 'Secret123');
        } catch (\RuntimeException $e) {
            // excepción esperada
        }
    }
}
