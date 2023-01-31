<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Facility extends Model
{
    use Singleton;

    protected $table = 'facilities';

    protected $fillable = ['room_id', 'name'];
}