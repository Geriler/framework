<?php
require_once 'Core/Router.php';
define('APPPATH', realpath('../app/'));

use Core\Router;

Router::start();