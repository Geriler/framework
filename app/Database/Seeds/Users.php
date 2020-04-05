<?php namespace App\Database\Seeds;

use App\Core\Database\Seeder;
use App\Models\User;
use Faker\Factory;
use Faker\Generator;

class Users extends Seeder
{
    private User $userModel;
    private Generator $faker;

    public function __construct()
    {
        $this->userModel = new User();
        $this->faker = Factory::create('ru_RU');
    }

    function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $this->userModel->insert([
                'name' => $this->faker->firstName($gender),
                'surname' => $this->faker->lastName($gender),
            ]);
        }
    }
}
