<?php

namespace Alura\Mvc\Controller;

class LoginFormController implements Controller
{
    public function process(): void
    {
        include_once __DIR__ . "/../../views/login-form.php";
    }
}
