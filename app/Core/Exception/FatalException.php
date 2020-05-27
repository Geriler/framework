<?php namespace App\Core\Exception;

use App\Core\View;
use Exception;

/*
 * It is assumed that this type of error may affects system elements.
 * Error page should have a minimum of dependencies.
 */

class FatalException
{
    static function renderError(Exception $exception)
    {
        $view = new View();
        $view->render('errors/fatal', [
            'title' => 'Fatal error',
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ], 500);
    }
}
