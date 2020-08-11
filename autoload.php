<?php
error_reporting(3);
require_once 'core/Paths.php';
require_once ROOTPATH . '/vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv(true);
$env = file_exists(ROOTPATH . '/.env') ? '/.env' : '/.env.example';
$dotenv->load(ROOTPATH . $env);
