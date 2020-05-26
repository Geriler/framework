<?php
try {
    require_once '../autoload.php';
} catch (Exception $e) {
    echo $e->getMessage();
}
use App\Core\Route;
require_once APPPATH . '/routes.php';
Route::start();
