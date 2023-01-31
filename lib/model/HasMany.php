<?php

namespace Lib\Model;

class HasMany extends Relationship
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

                    $arrays = is_array($model->$name) ? $model->$name : [];
                    $arrays[] = $datum;

                    $model->$name = $arrays;
                }
            }
        }
    }
}