<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class PasswordReset extends Model
{
    use Singleton;

    protected $table = 'password_resets';

    protected $fillable = ['user_id', 'email', 'token'];
}