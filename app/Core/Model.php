<?php namespace App\Core;

use App\Core\Database\Database;

class Model
{
    protected $id = 'id';
    protected $table = '';
    protected $fields = [];

    protected $softDelete = true;

    protected $createdAt = 'created_at';
    protected $updatedAt = 'updated_at';
    protected $deletedAt = 'deleted_at';

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

    public function update(int $id, array $data)
    {
        $database = Database::getInstant();
        $oldData = $this->get($this->id, $id)[0];
        $newData = [];
        foreach ($this->getFields() as $field) {
            if (isset($data[$field])) {
                $newData[$field] = '\'' . $data[$field] . '\'';
            } else {
                $newData[$field] = '\'' . $oldData->$field . '\'';
            }
        }
        $newData[$this->createdAt] = '\'' . $oldData->{$this->createdAt} . '\'';
        $newData[$this->updatedAt] = '\'' . date('Y-m-d H:i:s') . '\'';
        if ($oldData->{$this->deletedAt} == null) {
            $newData[$this->deletedAt] = 'NULL';
        } else {
            $newData[$this->deletedAt] = '\'' . $oldData->{$this->deletedAt} . '\'';
        }
        $query = '';
        foreach ($newData as $key => $value) {
            $query .= "{$key} = {$value},";
        }
        $query = mb_substr($query, 0, -1);
        $sql = "UPDATE {$this->table} SET {$query} WHERE {$this->id} = :id;";
        $database->query($sql, [
            ':id' => $id,
        ], static::class);
    }
}
