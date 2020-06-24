<?php namespace App\Core\Exception;

use App\Core\View;
use Exception;

class RouteNotFoundException extends Exception
{
    static function renderError(Exception $exception)
    {
        $view = new View();
        $view->render('errors/route_not_found', [
            'title' => 'Ошибка',
            'message' => $exception->getMessage(),
        ], 400);
    }
}
