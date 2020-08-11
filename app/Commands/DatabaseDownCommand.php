<?php namespace App\Commands;

use Core\{CLI\CLI, CLI\Command, Database\Database};

class DatabaseDownCommand extends Command
{
    static function run(array $arguments)
    {
        $classes = Database::getMigrationClasses();
        foreach ($classes as $class) {
            (new $class)->down();
            echo CLI::getColoredString($class . ' down success', 'green') . "\n";
        }
    }

    static function getInfo(): string
    {
        return 'Команда для удаления всех таблиц в БД';
    }
}
