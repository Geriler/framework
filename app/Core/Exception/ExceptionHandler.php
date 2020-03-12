<?php namespace App\Core\Exception;

use App\Core\View;
use Exception;

class ExceptionHandler
{
    static function handle(Exception $exception)
    {
        $view = new View();
        switch (get_class($exception)) {
            case PageNotFountException::class:
                $view->render('errors/404', [
                    'title' => 'Страница не найдена'
                ], 404);
                break;
            case DatabaseException::class:
            default:
                $view->render('errors/exception', [
                    'title' => 'Ошибка',
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                ], 500);
                break;
        }
    }
}
