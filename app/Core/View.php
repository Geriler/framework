<?php namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class View
{
    public function render(string $template, array $data = null)
    {
        $loader = new FilesystemLoader(APPPATH . '/Views/');
        $twig = new Environment($loader);
        $twig->addFunction(new TwigFunction('route_to', function(string $route, string $params = null) {
            return Route::getRouteByName($route) . '/' . $params;
        }));
        if (is_null($data)) {
            echo $twig->render($template . '.html.twig');
        } else {
            echo $twig->render($template . '.html.twig', $data);
        }
    }
}
