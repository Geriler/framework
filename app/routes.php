<?php

use App\Core\Route;

Route::setDefaultController('MainController');
Route::setDefaultAction('index');

Route::add('/hello', 'MainController@hello', 'hello');
Route::add('/user/create', 'MainController@addUser', 'addUser');
Route::add('/user/update/(\d+)', 'MainController@updateUser', 'updateUser');
Route::add('/user/delete/(\d+)', 'MainController@deleteUser', 'deleteUser');
