<?php namespace App\Core;

use App\Controllers\MainController;
use App\Core\Exception\ExceptionHandler;
use App\Core\Exception\RouteNotFoundException;
use Exception;

class Router
{
    private static array $routes = [];
    private static string $defaultController = MainController::class;
    private static string $defaultAction = 'index';

    protected static array $placeholders = [
        ":any" => "(.*)",
        ":num" => "(\d+)",
        ":alpha" => "(\w+)"
    ];

    public static function run(string $url)
    {
        return self::match($url);
    }

    private static function match(string $url)
    {
        $isFoundRoute = false;
        foreach (self::$routes as $route => $params) {
            preg_match($route, $url, $matches);
            if (!empty($matches)) {
                $isFoundRoute = true;
                unset($matches[0]);
                break;
            }
        }
        $params['params'] = $matches;
        return $isFoundRoute ? $params : null;
    }

    private static function add(string $route, string $class, string $action = null, string $name = null, array $method = []): void
    {
        $params = [
            'class' => $class,
            'action' => $action ?? self::$defaultAction,
            'method' => $method
        ];
        if (!is_null($name))
            $params['name'] = $name;
        self::$routes["~^\\{$route}$~"] = $params;
    }

    static function get(string $route, string $class, string $action = null, string $name = null): void
    {
        self::add($route, $class, $action, $name, ['GET', 'HEAD']);
    }

    static function post(string $route, string $class, string $action = null, string $name = null): void
    {
        self::add($route, $class, $action, $name, ['POST']);
    }

    static function patch(string $route, string $class, string $action = null, string $name = null): void
    {
        self::add($route, $class, $action, $name, ['PUT', 'PATCH']);
    }

    static function delete(string $route, string $class, string $action = null, string $name = null): void
    {
        self::add($route, $class, $action, $name, ['DELETE']);
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

    static function setDefaultController(string $controller): void
    {
        self::$defaultController = $controller;
    }

    static function getDefaultController(): string
    {
        return self::$defaultController;
    }

    static function setDefaultAction(string $action): void
    {
        self::$defaultAction = $action;
    }

    static function getDefaultAction(): string
    {
        return self::$defaultAction;
    }
}
