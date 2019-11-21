<?php namespace App\Core\Database;

abstract class Migration
{
    private $primary_key;
    private $fields;

    protected function primaryKey(string $key)
    {
        $this->primary_key = $key;
    }

    protected function addFields(array $fields)
    {
        $this->fields = $fields;
    }

    protected function createTable(string $table)
    {
        $connection = Database::getInstant();
        $fields = $this->fieldsToString($this->fields);
        $primaryKey = $this->primary_key;
        $connection->query("CREATE TABLE IF NOT EXISTS `{$table}` ({$fields} PRIMARY KEY ({$primaryKey}));");
    }

    protected function dropTable(string $table)
    {
        $connection = Database::getInstant();
        $connection->query("DROP TABLE IF EXISTS `{$table}`;");
    }

    private function fieldsToString(array $fields)
    {
        $string = '';
        foreach ($fields as $name => $params) {
            $constraint = $params['constraint'] != null ? $params['constraint'] : $this->defaultConstraint(strtoupper($params['type']));
            $constraint = !empty($constraint) ? '(' . $constraint . ')' : '';
            $unsigned = isset($params['unsigned']) && $params['unsigned'] ? 'UNSIGNED' : '';
            $default = isset($params['default']) ? "DEFAULT {$params['default']}" : '';
            $null = isset($params['null']) && !$params['null'] ? 'NOT NULL' : '';
            $auto_increment = isset($params['auto_increment']) && $params['auto_increment'] ? 'AUTO_INCREMENT' : '';
            $string .= " `{$name}` {$params['type']}{$constraint} {$unsigned} {$null} {$default} {$auto_increment} ,";
        }
        return $string;
    }

    private function defaultConstraint(string $type)
    {
        $constraint = [
            'TINYINT' => 4,
            'INT' => 11,
            'VARCHAR' => 255,
        ];
        if ($constraint[$type]) {
            return $constraint[$type];
        } else {
            return '';
        }
    }

    abstract function up();
    abstract function down();
}