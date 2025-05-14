<?php

namespace Alura\Mvc\Controller;

class LogoutController implements Controller
{
    public function process(): void
    {
        session_destroy();
        header(
            header: "Location: /login"
        );
    }
}
