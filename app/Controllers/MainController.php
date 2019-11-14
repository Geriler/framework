<?php namespace Controllers;

use Core\Controller;

class MainController extends Controller
{
    public function index()
    {
        $this->view->render('home', [
            'title' => 'Главная страница',
        ]);
    }

    public function hello()
    {
        $this->view->render('hello', [
            'title' => 'Hello, world!',
        ]);
    }
}
