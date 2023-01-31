<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class User extends Model
{
    use Singleton;

    protected $table = "users";

    protected $fillable = ['email', 'password', 'role'];

    const ROLE_ADMIN    = "admin";
    const ROLE_CUSTOMER = "customer";
    const ROLE_STAFF    = "staff";

    public function biodata() {
        return $this->hasOne(Biodata::class, 'user_id');
    }
}