<?php namespace App\Database\Seeds;

use App\Core\Database\Seeder;
use App\Models\User;

class Users extends Seeder
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    function run()
    {
        $this->userModel->insert([
            'name' => 'John',
            'surname' => 'Smith',
        ]);
    }
}
