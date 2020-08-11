<?php namespace App\Database\Seeds;

use Core\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(Users::class);
    }
}
