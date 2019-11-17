<?php namespace Controllers;

use Core\Controller;
use Models\User;

class MainController extends Controller
{
    public function index()
    {
        $user = new User();

        $this->view->render('home', [
            'title' => 'Главная страница',
            'users' => $user->all(),
        ]);
    }

    public function hello()
    {
        $this->view->render('hello', [
            'title' => 'Hello, world!',
        ]);
    }
}
