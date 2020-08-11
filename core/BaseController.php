<?php namespace Core;

abstract class BaseController
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View();
    }
}
