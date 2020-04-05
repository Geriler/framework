<?php namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel
{
    public string $id = 'user_id';
    protected string $table = 'users';
    protected array $fields = [
        'name', 'surname'
    ];
    protected bool $softDelete = true;
}
