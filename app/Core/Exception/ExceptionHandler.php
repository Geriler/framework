<?php namespace App\Core\Exception;

use App\Core\View;
use Exception;

class ExceptionHandler
{
    static function handle(Exception $exception)
    {
        $exception_class = get_class($exception);
        if (method_exists($exception_class, 'renderError')) {
            $exception_class::renderError();
        } else {
            $view = new View();
            $view->render('errors/exception', [
                'title' => 'Ошибка',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ], 500);
        }
    }
}
