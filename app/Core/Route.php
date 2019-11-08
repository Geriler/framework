<?php namespace Core;

require_once APPPATH . '/routes.php';

class Route
{
    private static $routes = [];

    static function start()
    {
        $controller = 'MainController';
        $action = 'index';

        $currentRoute = $_SERVER['REQUEST_URI'];

        $route = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($route[1])) {
            $controller = ucfirst($route[1]) . 'Controller';
        }
        if (!empty($route[2])) {
            $action = $route[2];
        }

        $isFoundRoute = false;
        foreach (self::$routes as $pattern => $route) {
            preg_match($pattern, $currentRoute, $matches);
            if (!empty($matches)) {
                $isFoundRoute = true;
                break;
            }
        }

        if ($isFoundRoute) {
            $class = explode('\\', $route[0]);
            if (count($class) == 1) $controller = $class[0];
            else $controller = $class[1];
            $action = $route[1];
        }

        preg_match('/(.*)Controller/', $controller, $matches);
        $modelFile = $matches[1] . 'Model.php';
        $modelPath = APPPATH . '/Models/';
        if (file_exists($modelPath . $modelFile)) {
            require_once $modelPath . $modelFile;
        }

        $controllerFile = $controller . '.php';
        $controllerPath = APPPATH . '/Controllers/';
        if (file_exists($controllerPath . $controllerFile)) {
            require_once $controllerPath . $controllerFile;
        } else {
            Route::errorPage404();
        }

        $classController = '\\Controllers\\' . $controller;
        $controller = new $classController;
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::errorPage404();
        }
    }

    static function errorPage404()
    {
        $view = new View();
        $view->render('errors/404');
    }

    static function add(string $route, string $class, string $action = null)
    {
        $route = "~^\\{$route}$~";
        if (is_null($action)) {
            preg_match('/(.*)@(.*)/', $class, $matches);
            $class = $matches[1];
            $action = $matches[2];
        }
        self::$routes[$route] = [$class, $action];
    }
}
