<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\UserRepository;
use Exception;

class LoginController implements Controller
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function process(): void
    {
        $email = filter_input(
            type: INPUT_POST,
            var_name: "email",
            filter: FILTER_VALIDATE_EMAIL
        );
        $password = filter_input(
            type: INPUT_POST,
            var_name: "password"
        );
        try {
            $user = $this->userRepository->find(email: $email);
            if (password_verify(
                password: $password,
                hash: $user->password
            )
            ) {
                header("Location: /?sucesso=0");
            } else {
                header("Location: /login");
            }
        } catch (Exception $e) {
            header("Location: /login");
        }
    }
}
