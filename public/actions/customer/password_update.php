<?php

require_once '../../../server.php';

$oldPassword    = $_POST['old_password'];
$password       = $_POST['password'];
$repeatPassword = $_POST['repeat_password'];

$u = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id = ?", [\Lib\Session\Session::get('user')['id']])->fetch(PDO::FETCH_OBJ);

if ($password != $repeatPassword) {
    redirect($routes['customers.profile.index']);
}

if (md5($oldPassword) == $u->password) {
    \App\Models\User::instance()->raw("UPDATE users SET password = ? WHERE id = ?", [md5($password), $u->id]);

    redirect($routes['customers.profile.index']);
}