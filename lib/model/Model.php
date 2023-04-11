<?php

namespace Lib\Model;

use App\Models\Biodata;
use Lib\Arr\Arr;
use Lib\Database\Connection;

class Model implements CreateReadUpdateDelete
{
    protected $connection;

    protected $table;
    protected $primaryKey = "id";

    protected $fillable = [];

    private $attributes = [];

    private $relations = [];

    private $data = [];

    private $rawSql = null;
    private $rawBindings = null;

    public function __construct()
    {
        $conn = Connection::instance();
        $conn->connect();

        $this->connection = $conn->getConnection();
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    public function fill($attributes)
    {
        $this->attributes = array_merge($attributes, $this->attributes);

        return $this;
    }

    public function with(...$relation)
    {
        foreach ($relation as $arg) {
            if (method_exists($this, $arg)) {
                $this->relations[$arg] = $this->$arg();
            }
        }

        return $this;
    }

    protected function hasOne($table, $foreignKey = '')
    {
        return new HasOne($table, $foreignKey);
    }

    protected function hasMany($table, $foreignKey = '')
    {
        return new HasMany($table, $foreignKey);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        // fetch all data
        $data = $statement->fetchAll();

        foreach ($data as $datum) {
            // clone self, we don't need to recreate the properties
            $model = clone $this;
            $model->hydrate($datum);

            $ids[] = $model->{$this->primaryKey};
            $models[] = $model;
        }

        $this->loadRelations($ids ?? [], $models);

        return $models ?? [];
    }

    private function loadRelations($ids, &$models)
    {
        foreach ($this->relations as $name => $relation) {

            if ($relation instanceof Relationship) {
                $data = $relation->loadRelation($ids);

                $relation->bindRelation($name, $data, $models);
            }

        }
    }

    public function hydrate($attributes) // bind the attributes
    {
        foreach ($this->fillable as $item) { // fill $this->data with fillable
            if (array_key_exists($item, $attributes)) {
                $this->{$this->primaryKey} = $attributes[$this->primaryKey]; // don't forget to add the primary key
                $this->$item = $attributes[$item];
            }
        }
    }

    public function create(array $attributes = [])
    {
        // data must be same with fillable
        $attr = Arr::only($this->fillable, $this->attributes);

        $columns = array_keys($attr);
        $values  = array_values($attr);

        // if parameter is not empty, we use value from that parameter
        if (count($attributes) > 0) {
            $data = $attributes;

            $columns = array_keys($data);
            $values  = array_values($data);

            // remove the primary key if exists in parameter
            if (array_key_exists($this->primaryKey, array_keys($attributes))) {
                unset($attributes[$this->primaryKey]);
            }
        }

        $columns = join(', ', $columns);

        $bindings = join(', ', array_fill(0, count($values), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES({$bindings})";

        $statement = $this->connection->prepare($sql);
        $statement->execute($values);

        $model = clone $this;
        $model->{$this->primaryKey} = $this->connection->lastInsertId();

        foreach ($this->fillable as $item) {
            $model->{$item} = $attributes[$item];
        }

        return $model;
    }

    public function raw(string $sql, $bindings = [])
    {
        if (!is_array($bindings)) {
            $bindings = [$bindings];
        }

        $this->rawSql = $sql;
        $this->rawBindings = $bindings;

        $statement = $this->connection->prepare($sql);
        $statement->execute($bindings);

        return $statement;
    }

    public function getTableName()
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function getFillable(): array
    {
        return $this->fillable;
    }
}