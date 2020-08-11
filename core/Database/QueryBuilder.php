<?php namespace Core\Database;

interface QueryBuilder
{
//    public function __construct(string $table);
    public function select(array $fields = ['*']): QueryBuilder;
    public function update(array $values): QueryBuilder;
    public function delete(): QueryBuilder;
    public function insert(array $values): QueryBuilder;
    public function where(string $field, string $value, string $operator = '='): QueryBuilder;
    public function limit(int $start, int $offset): QueryBuilder;
    public function get();
}
