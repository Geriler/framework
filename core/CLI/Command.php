<?php namespace Core\CLI;

abstract class Command
{
    abstract static function run(array $arguments);
    abstract static function getInfo(): string;
}
