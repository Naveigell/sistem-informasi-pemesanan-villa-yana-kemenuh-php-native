<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;
use Lib\Session\Session;

class User extends Model
{
    use Singleton;

    protected $table = "users";

    protected $fillable = ['name', 'email', 'password', 'role'];

    const ROLE_ADMIN    = "admin";
    const ROLE_CUSTOMER = "customer";
    const ROLE_STAFF    = "staff";

    public function biodata() {
        return $this->hasOne(Biodata::class, 'user_id');
    }

    public static function isAdmin()
    {
        return Session::get('user')['role'] == User::ROLE_ADMIN;
    }
}