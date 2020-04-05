<?php

use App\Controllers\MainController;
use App\Core\Route;

Route::setDefaultController(MainController::class);
Route::setDefaultAction('index');

Route::add('/hello', MainController::class, 'hello', 'hello');
Route::add('/user/create', MainController::class, 'addUser', 'addUser');
Route::add('/user/update/(\d+)', MainController::class, 'updateUser', 'updateUser');
Route::add('/user/delete/(\d+)', MainController::class, 'deleteUser', 'deleteUser');
