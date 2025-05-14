<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\User;
use Exception;
use PDO;

class UserRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function add(User $user): bool
    {
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $statement = $this->pdo->prepare(
            query: $sql
        );
        $password = password_hash(
            password: $user->password,
            algo: PASSWORD_ARGON2ID
        );
        return $statement->execute(
            [
                ":email" => $user->email,
                ":password" => $password
            ]
        );
    }

    public function remove(string $email): bool
    {
        $sql = "DELETE FROM users WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(
            [
                ":email" => $email
            ]
        );
    }

    public function update(User $user): bool
    {
        $sql = "UPDATE users SET email = :email, password = :password WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $password = password_hash(
            password: $user->password,
            algo: PASSWORD_ARGON2ID
        );
        return $statement->execute(
            [
                ":email" => user->email,
                ":password" => $password,
                ":id" => $user->id
            ]
        );
    }

    public function find(string $email): User
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        if ($statement->execute([ ":email" => $email ]) === false) {
            throw new Exception("Nenhum usuario encontrado");
        };
        return $this->_hydrate($statement->fetch());
    }

    /**
     * @return User[]
     */
    public function all(): array
    {
        $sql = "SELECT * FROM users";
        $statement = $this->pdo->query(
            query: $sql
        );
        $userList = $statement->fetchAll();
        return array_map(
            $this->_hydrate(...),
            $userList
        );
    }

    /**
     * @param array<User> $data
     */
    private function _hydrate(array $data): User
    {
        $user = new User(
            email: $data['email'],
            password: $data['password']
        );
        $user->setId($data['id']);
        return $user;
    }
}
