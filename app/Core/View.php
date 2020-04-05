<?php namespace App\Core;

use App\Core\Exception\ExceptionHandler;
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class View
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(APPPATH . '/Views/');
        $this->twig = new Environment($loader);
        $this->twig->addFunction(new TwigFunction('route_to', function(string $route, string ...$params) {
            $route = Route::getRouteByName($route) . '/' . implode('/', $params);
            return rtrim($route, '/');
        }));
    }

    public function render(string $template, array $data = null, int $code = null)
    {
        if (!is_null($code)) http_response_code($code);
        try {
            if (is_null($data)) {
                echo $this->twig->render($template . '.html.twig');
            } else {
                echo $this->twig->render($template . '.html.twig', $data);
            }
        } catch (Exception $exception) {
            ExceptionHandler::handle($exception);
        }
    }
}
