<?php namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use Faker\Factory;

class MainController extends Controller
{
    private $user;
    private $faker;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
        $this->faker = Factory::create('ru_RU');
    }

    public function index()
    {
        $this->view->render('home', [
            'title' => 'Главная страница',
            'users' => $this->user->all(true),
        ]);
    }

    public function hello()
    {
        $this->view->render('hello', [
            'title' => 'Hello, world!',
        ]);
    }

    public function addUser()
    {
        $gender = rand(0, 1) ? 'male' : 'female';
        $this->user->insert([
            'name' => $this->faker->firstName($gender),
            'surname' => $this->faker->lastName($gender),
        ]);
        header('Location: /');
    }

    public function updateUser($id)
    {
        header('Location: /');
    }

    public function deleteUser($id)
    {
        $this->user->delete($id);
        header('Location: /');
    }
}
