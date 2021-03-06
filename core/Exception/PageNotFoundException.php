<?php namespace Core\Exception;

use Core\View;
use Exception;

class PageNotFoundException extends Exception
{
    static function renderError()
    {
        $view = new View();
        $view->render('errors/404', [
            'title' => 'Страница не найдена'
        ], 404);
    }
}
