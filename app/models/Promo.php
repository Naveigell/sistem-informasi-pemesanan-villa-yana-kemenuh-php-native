<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Promo extends Model
{
    use Singleton;

    protected $table = 'promos';

    protected $fillable = ['title', 'description', 'price', 'start_date', 'end_date'];
}