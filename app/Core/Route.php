<?php namespace App\Core;

use App\Controllers\MainController;

require_once APPPATH . '/routes.php';

class Route
{
    private static $routes = [];
    private static $defaultController = MainController::class;
    private static $defaultAction = 'index';

    public function __construct()
    {
        self::start();
    }

    private function start()
    {
        $controller = self::$defaultController;
        $action = self::$defaultAction;

        $currentRoute = $_SERVER['REQUEST_URI'];

        $route = explode('/', $_SERVER['REQUEST_URI']);

        $isFoundRoute = false;
        foreach (self::$routes as $pattern => $route) {
            preg_match($pattern, $currentRoute, $matches);
            if (!empty($matches)) {
                $isFoundRoute = true;
                break;
            }
        }

        if ($isFoundRoute) {
            $controller = $route[0];
            $action = $route[1];
            unset($matches[0]);
        } else if ($currentRoute != '/') {
            header('Location: /');
        }

        $controller = new $controller;
        if (method_exists($controller, $action)) {
            $controller->$action(...$matches);
        } else {
            self::errorPage404();
            exit;
        }
    }

    private function errorPage404()
    {
        $view = new View();
        header('HTTP/2.0 404');
        $view->render('errors/404');
    }

    static function add(string $route, string $class, string $action)
    {
        $route = "~^\\{$route}$~";
        self::$routes[$route] = [$class, $action];
    }

    static function setDefaultController(string $controller)
    {
        self::$defaultController = $controller;
    }

    static function setDefaultAction(string $action)
    {
        self::$defaultAction = $action;
    }
}
