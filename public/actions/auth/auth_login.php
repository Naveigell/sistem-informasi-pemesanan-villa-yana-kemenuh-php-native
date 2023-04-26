<?php

require_once '../../../server.php';

use App\Models\User;
use Lib\Session\Session;

$email    = @$_POST['email'];
$password = md5(@$_POST['password']);

$user = User::instance()->raw("SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1", compact('email', 'password'))->fetch();

if (!$user) {
    Session::put("errors", [
        "auth" => "Data tidak ditemukan",
    ]);

    redirect($routes['auth.login.index']);
} else {
    Session::put("user", $user);

    if ($user['role'] == User::ROLE_ADMIN || $user['role'] == User::ROLE_STAFF) {
        redirect($routes['admin.dashboard.index']);
    } elseif ($user['role'] == User::ROLE_CUSTOMER) {
        redirect($routes['home.index']);
    }
}
?>