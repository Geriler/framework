<?php namespace App\Models;

use Core\BaseModel;

class User extends BaseModel
{
    public string $id = 'user_id';
    protected string $table = 'users';
    protected array $fields = [
        'name', 'surname'
    ];
    protected bool $softDelete = true;
}
