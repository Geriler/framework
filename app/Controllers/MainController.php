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
            'users' => $this->user->query->select()->get(),
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
        $this->user->query->insert([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
        ])->get();
        Helper::redirect('/');
    }

    public function addUser()
    {
        $gender = rand(0, 1) ? 'male' : 'female';
        $this->user->query->insert([
            'name' => $this->faker->firstName($gender),
            'surname' => $this->faker->lastName($gender),
        ])->get();
        Helper::redirect('/');
    }

    public function updateUser($id)
    {
        $gender = rand(0, 1) ? 'male' : 'female';
        $this->user->query->update([
            'name' => $this->faker->firstName($gender),
            'surname' => $this->faker->lastName($gender),
        ])->where('user_id', $id)->get();
        Helper::redirect('/');
    }

    public function deleteUser($id)
    {
        $this->user->query->delete()->where('user_id', $id)->get();
        Helper::redirect('/');
    }
}
