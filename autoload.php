<?php
error_reporting(3);
require_once 'app/Core/Paths.php';
require_once ROOTPATH . '/vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv(true);
$dotenv->load(ROOTPATH . '/.env');
