<?php namespace App\Core;

use App\Core\Exception\ExceptionHandler;
use App\Core\Exception\PageNotFountException;
use App\Core\Exception\RouteNotFoundException;
use Exception;

class Route
{
    private static array $routes = [];
    private static string $defaultController = 'MainController';
    private static string $defaultAction = 'index';

    public static function start()
    {
        $controller = '\\App\\Controllers\\' . self::$defaultController;
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

        try {
            if ($isFoundRoute) {
                $controller = '\\App\\Controllers\\' . $route['class'];
                $action = $route['action'];
                unset($matches[0]);
            } else if ($currentRoute != '/') {
                throw new PageNotFountException;
            }

            $controller = new $controller;
            if (method_exists($controller, $action)) {
                if (is_array($matches))
                    $controller->$action(...$matches);
                else
                    $controller->$action();
            } else {
                throw new PageNotFountException;
            }
        } catch (Exception $exception) {
            ExceptionHandler::handle($exception);
        }
    }

    static function add(string $route, string $class, string $name = null)
    {
        preg_match('/^(\w+)(\@(\w+)|)$/', $class, $matches);
        $params = [
            'class' => $matches[1],
            'action' => $matches[3] == '' ? 'index' : $matches[3],
        ];
        if (!is_null($name))
            $params['name'] = $name;
        self::$routes["~^\\{$route}$~"] = $params;
    }

    static function getRouteByName(string $name)
    {
        $route = '';
        $isFoundRoute = false;
        foreach (self::$routes as $route => $params) {
            if ($name == $params['name']) {
                $isFoundRoute = true;
                break;
            }
        }
        try {
            if ($isFoundRoute) {
                preg_match('/\~\^\\\(.*)\$\~/', $route, $matches);
                $route = preg_replace('/(\/\w+\/\w+)\/(.*)/', '$1', $matches[1]);
                return $route;
            } else {
                throw new RouteNotFoundException("Route $name not found");
            }
        } catch (Exception $exception) {
            ExceptionHandler::handle($exception);
        }
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
