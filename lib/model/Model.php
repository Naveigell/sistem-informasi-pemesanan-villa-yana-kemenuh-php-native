<?php

namespace Lib\Model;

use Lib\Arr\Arr;
use Lib\Database\Connection;

class Model
{
    private $connection;

    protected $table;
    protected $primaryKey = "id";

    protected $fillable = [];

    private $attributes = [];

    public function __construct()
    {
        $conn = Connection::instance();
        $conn->connect();

        $this->connection = $conn->getConnection();
    }

    public function fill($attributes)
    {
        $this->attributes = array_merge($attributes, $this->attributes);

        return $this;
    }

    public function create(array $attributes = [])
    {
        // remove the data if the keys not same with fillable
        $attr = Arr::only($this->attributes, $this->fillable);

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
    }
}