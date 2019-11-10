<?php namespace Core;

require_once APPPATH . '/routes.php';

class Route
{
    private static $routes = [];

    public function __construct()
    {
        self::start();
    }

    private function start()
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

        $controllerFile = $controller . '.php';
        $controllerPath = APPPATH . '/Controllers/';
        if (!file_exists($controllerPath . $controllerFile)) {
            self::errorPage404();
            exit;
        }

        $classController = '\\Controllers\\' . $controller;
        $controller = new $classController;
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            self::errorPage404();
            exit;
        }
    }

    private function errorPage404()
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
