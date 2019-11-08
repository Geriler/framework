<?php
error_reporting(1);
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../app/' . str_replace('\\', DIRECTORY_SEPARATOR,
            $className) . '.php';
});
require_once '../app/bootstrap.php';
