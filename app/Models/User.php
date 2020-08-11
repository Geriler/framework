<?php namespace App\Models;

use Core\BaseModel;
use Core\Database\MySQLQueryBuilder;

class User extends BaseModel
{
    protected string $table = 'users';

    public function __construct()
    {
        parent::__construct(new MySQLQueryBuilder($this->table, self::class));
    }
}
