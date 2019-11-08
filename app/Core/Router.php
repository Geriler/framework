<?php namespace Core;

class Router
{
    static function start()
    {
        $controller = 'MainController';
        $action = 'index';

        $routes = require_once APPPATH . '/routes.php';
        $currentRoute = substr($_SERVER['REQUEST_URI'], 1);

        $route = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($route[1])) {
            $controller = ucfirst($route[1]) . 'Controller';
        }
        if (!empty($route[2])) {
            $action = $route[2];
        }

        $isFoundRoute = false;
        foreach ($routes as $pattern => $route) {
            preg_match($pattern, $currentRoute, $matches);
            if (!empty($matches)) {
                $isFoundRoute = true;
                break;
            }
        }

        if ($isFoundRoute) {
            $controller = explode('\\', $route[0])[1];
            $action = $route[1];
        }

        require_once APPPATH . '/Controllers/' . $controller . '.php';
        $controller = '\\Controllers\\' . $controller;
        $controller = new $controller;
        $controller->$action();
    }
}
