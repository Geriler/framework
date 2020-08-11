<?php namespace Core\CLI;

use Core\Exception\{CommandNotExist, ExceptionHandler};
use Exception;

require_once APPPATH . '/commands.php';

class CLI
{
    private static array $commands = [];
    private static array $foreground_colors = [];
    private static array $background_colors = [];

    public static function run(string $command, array $arguments)
    {
        try {
            $command_class = self::$commands[$command];
            if (class_exists($command_class)) {
                $command_class::run($arguments);
            } else {
                throw new CommandNotExist("Command '$command' not exist.");
            }
        } catch (Exception $exception) {
            ExceptionHandler::handle($exception);
        }
        echo "\n";
        echo CLI::getColoredString("Command '$command' completed successfully", 'green') . "\n";
    }

    public static function addCommand(string $command, string $class)
    {
        self::$commands[$command] = $class;
    }

    public static function listCommands()
    {
        echo self::getColoredString('list', 'green') . ' - ' . self::getColoredString('Вывод всех команд', 'yellow') . "\n";
        foreach (self::$commands as $command => $class) {
            echo self::getColoredString($command, 'green') . ' - ' . self::getColoredString($class::getInfo(), 'yellow') . "\n";
        }
    }

    public static function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = '';
        self::getForegroundColors();
        self::getBackgroundColors();
        if (isset(self::$foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . self::$foreground_colors[$foreground_color] . "m";
        }
        if (isset(self::$background_colors[$background_color])) {
            $colored_string .= "\033[" . self::$background_colors[$background_color] . "m";
        }
        $colored_string .=  $string . "\033[0m";
        return $colored_string;
    }

    private static function getForegroundColors() {
        self::$foreground_colors = [
            'black' => '0;30',
            'dark_gray' => '1;30',
            'blue' => '0;34',
            'light_blue' => '1;34',
            'green' => '0;32',
            'light_green' => '1;32',
            'cyan' => '0;36',
            'light_cyan' => '1;36',
            'red' => '0;31',
            'light_red' => '1;31',
            'purple' => '0;35',
            'light_purple' => '1;35',
            'brown' => '0;33',
            'yellow' => '1;33',
            'light_gray' => '0;37',
            'white' => '1;37',
        ];
        return array_keys(self::$foreground_colors);
    }

    private static function getBackgroundColors() {
        self::$background_colors = [
            'black' => '40',
            'red' => '41',
            'green' => '42',
            'yellow' => '43',
            'blue' => '44',
            'magenta' => '45',
            'cyan' => '46',
            'light_gray' => '47',
        ];
        return array_keys(self::$background_colors);
    }
}
