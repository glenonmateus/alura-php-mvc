<?php

namespace Alura\Mvc\Controller;

class LogoutController implements Controller
{
    public function process(): void
    {
        // session_destroy();
        unset($_SESSION["logado"]);
        header(
            header: "Location: /login"
        );
    }
}
