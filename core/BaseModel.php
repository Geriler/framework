<?php namespace Core;

use Core\Database\QueryBuilder;

abstract class BaseModel
{
    public QueryBuilder $query;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->query = $queryBuilder;
    }
}
