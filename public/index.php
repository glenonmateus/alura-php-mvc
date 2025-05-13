<?php

use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/config.php";

/** @var PDO $pdo */
$videoRepository = new VideoRepository($pdo);

$routes = include_once __DIR__ . "/../config/routes.php";

$pathInfo = explode("?", $_SERVER["REQUEST_URI"])[0] ?? "/";
$httpMethod = $_SERVER["REQUEST_METHOD"];

$key = "$httpMethod|$pathInfo";

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];
    $controller = new $controllerClass($videoRepository);
} else {
    $controller = new Error404Controller();
}
/** @var Controller $controller */
$controller->process();
