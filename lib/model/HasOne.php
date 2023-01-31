<?php

namespace Lib\Model;

class HasOne extends Relationship implements CreateReadUpdateDelete
{
    public function __construct($table, $foreignKey)
    {
        parent::__construct($table, $foreignKey);
    }

    public function bindRelation($name, $data, &$models)
    {
        foreach ($models as $model) { // loop the model
            foreach ($data as $datum) { // loop the data
                if ($model->{$model->primaryKey} == $datum->{$this->foreignKey}) { // check if foreign key and primary key are same
                    if (!$model->$name) {
                        $model->$name = $datum;
                    }
                }
            }
        }
    }
}