<?php
define('ROOTPATH', realpath(__DIR__ . '/../'));
define('APPPATH', realpath(ROOTPATH . '/app/'));
require_once ROOTPATH . '/vendor/autoload.php';
use Core\Route;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(ROOTPATH . '/.env');

new Route();
