<?php

use Core\Route;

Route::setDefaultController('MainController');
Route::setDefaultAction('index');

Route::add('/hello', 'MainController@hello');
