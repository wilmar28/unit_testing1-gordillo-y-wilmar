<?php
// Paso 4 — Mocks e inyección de dependencias

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?array;
    public function save(array $userData): bool;
}

class UserService
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function register(string $email, string $password): array
    {
        if ($this->repository->findByEmail($email)) {
            throw new \RuntimeException("El email '$email' ya está registrado.");
        }

        $user = [
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role'     => 'user',
        ];

        $this->repository->save($user);

        return $user;
    }
}
