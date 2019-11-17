<?php namespace Database\Migrations;

use Core\Database\Migration;

class AddUsers extends Migration
{
    public function up()
    {
        $this->addFields([
            'id' => [
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
        ]);
        $this->primaryKey('id');
        $this->createTable('users');
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
