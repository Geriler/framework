<?php

use App\Controllers\MainController;
use App\Core\Router;

Router::setDefaultController(MainController::class);
Router::setDefaultAction('index');

Router::get('/', MainController::class, 'index', 'homepage');
Router::get('/hello', MainController::class, 'hello', 'hello');
Router::get('/user/create', MainController::class, 'addUser', 'addUser');
Router::post('/user/create_user', MainController::class, 'createUser', 'createUser');
Router::get('/user/update/(\d+)', MainController::class, 'updateUser', 'updateUser');
Router::get('/user/delete/(\d+)', MainController::class, 'deleteUser', 'deleteUser');
