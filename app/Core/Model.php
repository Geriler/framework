<?php namespace Core;

use Core\Database\Database;

class Model
{
    protected $id = 'id';
    protected $table = '';
    protected $fields = [];

    protected $softDelete = true;

    protected $createdAt = 'created_at';
    protected $updatedAt = 'updated_at';
    protected $deletedAt = 'deleted_at';

    public function all(bool $deleted = false)
    {
        $database = Database::getInstant();
        if ($deleted) {
            $sql = "SELECT * FROM {$this->table};";
        } else {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->deletedAt} IS NULL;";
        }
        $result = $database->query($sql, [], static::class);
        return $result;
    }

    public function get(string $field, string $value)
    {
        $database = Database::getInstant();
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value;";
        $result = $database->query($sql, [
            ':value' => $value,
        ], static::class);
        return $result;
    }

    public function insert(array $values)
    {
        $database = Database::getInstant();
        $fields = implode(',', [implode(',', $this->fields), $this->createdAt, $this->updatedAt, $this->deletedAt]);
        $newValues = [];
        foreach ($this->fields as $field) {
            $newValues[$field] = '\'' . $values[$field] . '\'';
        }
        $newValues[$this->createdAt] = '\'' . date('Y-m-d H:i:s') . '\'';
        $newValues[$this->updatedAt] = '\'' . date('Y-m-d H:i:s') . '\'';
        $newValues[$this->deletedAt] = 'NULL';
        $values = implode(',', $newValues);
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values});";
        $database->query($sql, [], static::class);
    }

    public function delete(int $id)
    {
        $database = Database::getInstant();
        if ($this->softDelete) {
            $sql = "UPDATE {$this->table} SET {$this->deletedAt} = :time WHERE {$this->id} = :id";
            $database->query($sql, [
                ':time' => date('Y-m-d H:i:s'),
                ':id' => $id,
            ], static::class);
        } else {
            $sql = "DELETE FROM {$this->table} WHERE {$this->id} = :id";
            $database->query($sql, [
                ':id' => $id,
            ], static::class);
        }
    }
}
