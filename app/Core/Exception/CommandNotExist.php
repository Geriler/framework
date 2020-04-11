<?php namespace App\Core\Exception;

use App\Core\CLI\CLI;
use Exception;

class CommandNotExist extends Exception
{
    static function renderError(Exception $exception)
    {
        echo CLI::getColoredString($exception->getMessage(), 'red') . "\n";
        echo CLI::getColoredString('Use \'php migration\' or \'php migration list\' for view list of commands.', 'yellow') . "\n";
    }
}
