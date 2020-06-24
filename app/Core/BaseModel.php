<?php namespace App\Core;

use App\Core\Database\Database;

abstract class BaseModel
{
    protected string $id = 'id';
    protected string $table = '';
    protected array $fields = [];

    protected bool $softDelete = true;

    protected string $createdAt = 'created_at';
    protected string $updatedAt = 'updated_at';
    protected string $deletedAt = 'deleted_at';

    private function getFields()
    {
        return $this->fields;
    }

    public function all(bool $deleted = false)
    {
        $database = Database::getInstant();
        if ($deleted) {
            $sql = "SELECT * FROM {$this->table};";
        } else {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->deletedAt} IS NULL;";
        }
        return $database->query($sql, [], static::class);
    }

    public function get(string $field, string $value)
    {
        $database = Database::getInstant();
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value;";
        return $database->query($sql, [
            ':value' => $value,
        ], static::class);
    }

    public function insert(array $values)
    {
        $database = Database::getInstant();
        $newValues = [];
        $fields = '';
        foreach ($values as $field => $value) {
            $newValues[$field] = '\'' . $value . '\'';
            $fields = implode(',', [$fields, $field]);
        }
        $fields = ltrim(implode(',', [$fields, $this->createdAt, $this->updatedAt]), ',');
        $newValues[$this->createdAt] = '\'' . date('Y-m-d H:i:s') . '\'';
        $newValues[$this->updatedAt] = '\'' . date('Y-m-d H:i:s') . '\'';
        $values = implode(',', $newValues);
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values});";
        return $database->query($sql, [], static::class);
    }

    public function delete(int $id)
    {
        $database = Database::getInstant();
        if ($this->softDelete) {
            $sql = "UPDATE {$this->table} SET {$this->deletedAt} = :time WHERE {$this->id} = :id";
            return $database->query($sql, [
                ':time' => date('Y-m-d H:i:s'),
                ':id' => $id,
            ], static::class);
        } else {
            $sql = "DELETE FROM {$this->table} WHERE {$this->id} = :id";
            return $database->query($sql, [
                ':id' => $id,
            ], static::class);
        }
    }

    public function update(int $id, array $data)
    {
        $database = Database::getInstant();
        $newData = [];
        foreach ($data as $field => $value) {
            $newData[$field] = '\'' . $value . '\'';
        }
        $newData[$this->updatedAt] = '\'' . date('Y-m-d H:i:s') . '\'';
        $query = '';
        foreach ($newData as $key => $value) {
            $query .= "{$key} = {$value},";
        }
        $query = mb_substr($query, 0, -1);
        $sql = "UPDATE {$this->table} SET {$query} WHERE {$this->id} = :id;";
        return $database->query($sql, [
            ':id' => $id,
        ], static::class);
    }
}
