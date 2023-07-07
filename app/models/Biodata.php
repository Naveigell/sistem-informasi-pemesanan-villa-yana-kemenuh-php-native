<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Biodata extends Model
{
    use Singleton;

    protected $table = 'biodatas';

    protected $fillable = ['user_id', 'phone', 'address', 'identity_card', 'avatar'];
}