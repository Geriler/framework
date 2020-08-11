<?php namespace Core;

use Core\Exception\ExceptionHandler;
use Core\Exception\PageNotFoundException;
use Exception;

class App
{
    public function run()
    {
        $current_url = parse_url($_SERVER['REQUEST_URI'])['path'];
        $request = new Request();
        $route = Router::run($current_url);
        try {
            if (!empty($route)) {
                if (!in_array($_SERVER['REQUEST_METHOD'], $route['method'])) {
                    throw new Exception("This route doesn't support {$_SERVER['REQUEST_METHOD']}. Use " . implode('/', $route['method']));
                }
                $class = $route['class'];
                $action = $route['action'];
                $controller = new $class;
                if (empty($route['params'])) {
                    $controller->$action($request);
                } else {
                    $controller->$action(...$route['params']);
                }
            } else {
                http_response_code(404);
                throw new PageNotFoundException;
            }
        } catch (Exception $exception) {
            ExceptionHandler::handle($exception);
        }
    }
}
