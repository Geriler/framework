<?php namespace App\Commands;

use Core\CLI\{CLI, Command};

class DatabaseSeedsCommand extends Command
{
    static function run(array $arguments)
    {
        $class = '\\App\\Database\\Seeds\\';
        if ($arguments[0] == null) {
            $class .= 'DatabaseSeeder';
        } else {
            $class .= $arguments[0];
        }
        (new $class)->run();
        echo CLI::getColoredString("Seeds '{$class}' success", 'green') . "\n";
    }

    static function getInfo(): string
    {
        return 'Команда для заполнения БД начальными значениями';
    }
}
