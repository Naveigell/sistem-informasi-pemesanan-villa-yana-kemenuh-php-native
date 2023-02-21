<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Payment extends Model
{
    use Singleton;

    protected $table = 'payments';

    protected $fillable = ['proof'];
}