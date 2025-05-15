<?php

use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Repository\UserRepository;
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/config.php";

/** @var PDO $pdo */
$videoRepository = new VideoRepository($pdo);
$userRepository = new UserRepository($pdo);

$routes = include_once __DIR__ . "/../config/routes.php";

$pathInfo = explode("?", $_SERVER["REQUEST_URI"])[0] ?? "/";
$httpMethod = $_SERVER["REQUEST_METHOD"];

$key = "$httpMethod|$pathInfo";

session_start();
session_regenerate_id();
// if (isset($_SESSION['logado'])) {
//     $logado = $_SESSION['logado'];
//     unset($_SESSION['logado']);
//     session_regenerate_id();
//     $_SESSION['logado'] = $logado;
// }

if (!array_key_exists(key: 'logado', array: $_SESSION) && $pathInfo !== "/login") {
    header(header: "Location: /login");
    return;
}

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];
    if ($pathInfo === "/login") {
        $controller = new $controllerClass($userRepository);
    } else {
        $controller = new $controllerClass($videoRepository);
    }
} else {
    $controller = new Error404Controller();
}
/** @var Controller $controller */
$controller->process();
