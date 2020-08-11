<?php

namespace Core\Database;

use Exception;
use stdClass;

class MySQLQueryBuilder implements QueryBuilder
{
    protected string $table = '';
    protected stdClass $query;
    protected string $class;

    public function __construct(string $table, string $class)
    {
        $this->table = $table;
        $this->class = $class;
    }

    protected function reset(): void
    {
        $this->query = new stdClass();
    }

    public function select(array $fields = ['*']): MySQLQueryBuilder
    {
        $this->reset();
        $this->query->base = 'SELECT ' . implode(', ', $fields) . ' FROM ' . $this->table;
        $this->query->type = 'select';
        return $this;
    }

    public function update(array $values): MySQLQueryBuilder
    {
        $this->reset();
        $this->query->base = 'UPDATE ' . $this->table . ' SET ';
        $data = '';
        foreach ($values as $field => $value) {
            $data .= "$field = '$value', ";
        }
        $this->query->base .= rtrim($data, ', ');
        $this->query->type = 'update';
        return $this;
    }

    public function delete(): MySQLQueryBuilder
    {
        $this->reset();
        $this->query->base = 'DELETE FROM ' . $this->table;
        $this->query->type = 'delete';
        return $this;
    }

    public function insert(array $data): QueryBuilder
    {
        $this->reset();
        $this->query->base = 'INSERT INTO ' . $this->table;
        $this->query->type = 'insert';
        $fields = [];
        $values = [];
        foreach ($data as $field => $value) {
            $fields[] = $field;
            $values[] = "'$value'";
        }
        $this->query->base .= '(' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
        return $this;
    }

    public function where(string $field, string $value, string $operator = '='): MySQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new Exception('WHERE can only be added to SELECT, UPDATE or DELETE');
        }
        $this->query->where[] = "$field $operator '$value'";
        return $this;
    }

    public function limit(int $start, int $offset): MySQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new Exception('LIMIT can only be added to SELECT');
        }
        $this->query->limit = " LIMIT $start, $offset";
        return $this;
    }

    public function get()
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= ' WHERE ' . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ';';
        $db = Database::getInstant();
        return $db->query($sql, $this->class);
    }
}
