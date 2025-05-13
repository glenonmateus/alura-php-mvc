<?php

define("DB_NAME", "aluraplay");
// define("DB_HOST", "127.0.0.1");
define("DB_HOST", "database");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");

$pdo = new PDO(
    dsn: "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
    username: DB_USERNAME,
    password: DB_PASSWORD,
    options: [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);
