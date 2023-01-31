<?php

namespace Lib\Model;

use Lib\Application\Singleton;

abstract class Relationship extends Model implements RelationImpl
{
    protected $foreignKey;
    protected $foreignTable;

    public function __construct($table, $foreignKey)
    {
        parent::__construct();

        $this->foreignKey = $foreignKey;
        $this->foreignTable = $table;
    }

    public function loadRelation($ids)
    {
        if (count($ids) <= 0) {
            return [];
        }

        $ids = join(', ', $ids);

        $table = new $this->foreignTable();

        $sql = "SELECT * FROM {$table->getTableName()} WHERE {$this->foreignKey} IN ({$ids})";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $data = $statement->fetchAll();

        foreach ($data as $datum) {
            $model = new $this->foreignTable();
            $model->hydrate($datum);

            $models[] = $model;
        }

        return $models ?? [];
    }

    public abstract function bindRelation($name, $data, &$models);

    /**
     * @return mixed
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @return mixed
     */
    public function getForeignTable()
    {
        return $this->foreignTable;
    }
}