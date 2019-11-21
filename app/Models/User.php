<?php namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public $id = 'user_id';
    protected $table = 'users';
    protected $fields = [
        'name', 'surname'
    ];
    protected $softDelete = true;
}
