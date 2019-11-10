<?php
define('APPPATH', realpath('../app/'));
require_once APPPATH . '/../vendor/autoload.php';
use Core\Route;
new Route();
