<?php
error_reporting(3);
require_once 'app/Core/Paths.php';
require_once ROOTPATH . '/vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(ROOTPATH . '/.env');

spl_autoload_register(function (string $className) {
    require_once APPPATH . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
});
