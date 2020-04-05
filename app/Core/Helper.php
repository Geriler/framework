<?php namespace App\Core;

class Helper
{
    public static function redirect(string $route): void
    {
        header("Location: $route");
    }
}
