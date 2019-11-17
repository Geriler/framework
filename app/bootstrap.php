<?php
require_once 'Core/Paths.php';
spl_autoload_register(function (string $className) {
    require_once str_replace('\\', DIRECTORY_SEPARATOR,
            $className) . '.php';
});
require_once ROOTPATH . '/vendor/autoload.php';
use Core\Route;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(ROOTPATH . '/.env');

new Route();
