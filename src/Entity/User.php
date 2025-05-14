<?php

namespace Alura\Mvc\Entity;

class User
{
    public readonly int $id;

    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
