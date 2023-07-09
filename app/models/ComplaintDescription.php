<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class ComplaintDescription extends Model
{
    use Singleton;

    protected $table = 'complaint_descriptions';

    protected $fillable = ['user_id', 'complaint_id', 'image', 'description'];
}