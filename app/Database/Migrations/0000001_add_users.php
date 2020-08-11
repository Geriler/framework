<?php namespace App\Database\Migrations;

use Core\Database\Migration;

class AddUsers extends Migration
{
    public function up()
    {
        $this->addFields([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'surname' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
            'updated_at' => [
                'type' => 'DATETIME'
            ],
            'deleted_at' => [
                'type' => 'DATETIME'
            ],
        ]);
        $this->primaryKey('user_id');
        $this->createTable('users');
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
