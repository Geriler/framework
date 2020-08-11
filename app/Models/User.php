<?php namespace App\Models;

use Core\BaseModel;
use Core\Registry;

class User extends BaseModel
{
    protected string $table = 'users';

    public function __construct()
    {
        $registry = Registry::getInstant();
        parent::__construct(new $registry->db_driver($this->table, self::class));
    }
}
