<?php namespace Models;

use Core\Model;

class User extends Model
{
    public $id = 'user_id';
    protected $table = 'users';
    protected $fields = [
        'name', 'surname'
    ];
    protected $softDelete = true;
}
