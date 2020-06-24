<?php

use App\Controllers\MainController;
use App\Core\Route;

Route::setDefaultController(MainController::class);
Route::setDefaultAction('index');

Route::get('/hello', MainController::class, 'hello', 'hello');
Route::get('/user/create', MainController::class, 'addUser', 'addUser');
Route::post('/user/create_user', MainController::class, 'createUser', 'createUser');
Route::get('/user/update/(\d+)', MainController::class, 'updateUser', 'updateUser');
Route::get('/user/delete/(\d+)', MainController::class, 'deleteUser', 'deleteUser');
