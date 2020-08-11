<?php namespace Core\Database;

abstract class Seeder
{
    protected function call($class)
    {
        (new $class())->run();
    }

    abstract function run();
}
