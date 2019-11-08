<?php namespace Controllers;

use Core\Controller;

class MainController extends Controller
{
    public function index()
    {
        $this->view->render('main', [
            'title' => 'Главная страница',
            'body' => 'This is \'index\' method.',
        ]);
    }

    public function hello()
    {
        $this->view->render('main', [
            'title' => 'Hello world',
            'body' => 'Hello world',
        ]);
    }
}
