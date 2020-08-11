<?php namespace Core;

class Registry
{
    private static array $objects = [];
    private static $instant;

    private function __construct()
    {
        $config = require_once __DIR__ . '/config.php';
        foreach ($config as $name => $value) {
            $env_name = getenv(mb_strtoupper($name));
            if (!empty($value[$env_name])) {
                self::$objects[$name] = $value[$env_name];
            }
        }
    }

    public static function getInstant(): self
    {
        if (self::$instant == null) {
            self::$instant = new self();
        }
        return self::$instant;
    }

    public function __get(string $name)
    {
        if (isset(self::$objects[$name])) {
            return self::$objects[$name];
        }
        return null;
    }
}
