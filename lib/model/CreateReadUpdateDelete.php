<?php

namespace Lib\Model;

// don't know how to name this
interface CreateReadUpdateDelete
{
    public function create(array $attributes = []);

    public function raw(string $sql, array $bindings = []);
}