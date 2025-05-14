<?php

namespace Alura\Mvc\Controller;

class LoginFormController implements Controller
{
    public function process(): void
    {
        if (array_key_exists(
            key: 'logado',
            array: $_SESSION
        )
        ) {
            header(
                header: "Location: /"
            );
        }
        include_once __DIR__ . "/../../views/login-form.php";
    }
}
