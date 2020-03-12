<?php namespace App\Core;

use App\Controllers\MainController;

class Route
{
    private static $routes = [];
    private static $defaultController = MainController::class;
    private static $defaultAction = 'index';

    public function __construct()
    {
        require_once APPPATH . '/routes.php';
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
            $controller = $route['class'];
            $action = $route['action'];
            unset($matches[0]);
        } else if ($currentRoute != '/') {
            header('Location: /');
        }

        $controller = new $controller;
        if (method_exists($controller, $action)) {
            if (is_array($matches))
                $controller->$action(...$matches);
            else
                $controller->$action();
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

    static function add(string $route, string $class, string $action, string $name = null)
    {
        $params = [
            'class' => $class,
            'action' => $action
        ];
        if (!is_null($name))
            $params['name'] = $name;
        self::$routes["~^\\{$route}$~"] = $params;
    }

    static function getRouteByName(string $name)
    {
        $route = '';
        foreach (self::$routes as $route => $params) {
            if (array_search($name, $params)) {
                break;
            }
        }
        preg_match('/\~\^\\\(.*)\$\~/', $route, $matches);
        $route = preg_replace('/(\/\w+\/\w+)\/(.*)/', '$1', $matches[1]);
        return $route;
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
