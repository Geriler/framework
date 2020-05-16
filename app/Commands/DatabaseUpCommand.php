<?php namespace App\Commands;

use App\Core\{CLI\CLI, CLI\Command, Database\Database};

class DatabaseUpCommand extends Command
{
    static function run(array $arguments)
    {
        $classes = Database::getMigrationClasses();
        foreach ($classes as $class) {
            (new $class)->up();
            echo CLI::getColoredString($class . ' up success', 'green') . "\n";
        }
    }

    static function getInfo(): string
    {
        return 'Команда для поднятия БД';
    }
}
