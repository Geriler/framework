<?php namespace App\Core\CLI;

abstract class Command
{
    private static string $command = '';

    public static function getCommand(): string
    {
        return static::$command;
    }

    abstract static function run(array $arguments);
    abstract static function getInfo(): string;
}
