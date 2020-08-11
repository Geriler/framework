<?php

if (phpversion() < 7.4) {
    exit('This framework works with PHP version 7.4+. Your PHP version is ' . phpversion() . '.');
}

try {
    require_once __DIR__ . '/../autoload.php';
} catch (Exception $e) {
    \Core\Exception\FatalException::renderError($e);
    exit();
}

require_once APPPATH . '/routes.php';
$app = new \Core\App();
$app->run();
