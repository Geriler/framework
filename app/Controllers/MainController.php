<?php namespace App\Controllers;

use Core\{BaseController, Helper, Request};
use App\Models\User;
use Faker\Factory;
use Faker\Generator;

class MainController extends BaseController
{
    private User $user;
    private Generator $faker;

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

    public function createUser(Request $request)
    {
        $this->user->insert([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
        ]);
        Helper::redirect('/');
    }

    public function addUser()
    {
        $gender = rand(0, 1) ? 'male' : 'female';
        $this->user->insert([
            'name' => $this->faker->firstName($gender),
            'surname' => $this->faker->lastName($gender),
        ]);
        Helper::redirect('/');
    }

    public function updateUser($id)
    {
        $gender = rand(0, 1) ? 'male' : 'female';
        $this->user->update($id, [
            'name' => $this->faker->firstName($gender),
            'surname' => $this->faker->lastName($gender),
        ]);
        Helper::redirect('/');
    }

    public function deleteUser($id)
    {
        $this->user->delete($id);
        Helper::redirect('/');
    }
}
