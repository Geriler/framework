<?php

if (phpversion() < 7.4) {
    exit('This framework works with PHP version 7.4+. Your PHP version is ' . phpversion() . '.');
}

try {
    require_once '../autoload.php';
} catch (Exception $e) {
    App\Core\Exception\FatalException::renderError($e);
    exit();
}

use App\Core\Route;

require_once APPPATH . '/routes.php';
Route::start();
