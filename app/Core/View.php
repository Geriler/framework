<?php namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public function render(string $template, array $data = null)
    {
        $loader = new FilesystemLoader(APPPATH . '/Views/');
        $twig = new Environment($loader);
        if (is_null($data)) {
            echo $twig->render($template . '.html.twig');
        } else {
            echo $twig->render($template . '.html.twig', $data);
        }
    }
}
