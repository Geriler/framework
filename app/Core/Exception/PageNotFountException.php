<?php namespace App\Core\Exception;

use App\Core\View;
use Exception;

class PageNotFountException extends Exception
{
    static function renderError()
    {
        $view = new View();
        $view->render('errors/404', [
            'title' => 'Страница не найдена'
        ], 404);
    }
}
