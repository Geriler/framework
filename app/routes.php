<?php

use App\Controllers\MainController;
use App\Core\Route;

Route::setDefaultController(MainController::class);
Route::setDefaultAction('index');

Route::add('/hello', MainController::class, 'hello');
