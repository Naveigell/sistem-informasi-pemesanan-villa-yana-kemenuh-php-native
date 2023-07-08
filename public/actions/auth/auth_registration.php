<?php

use Lib\Session\Session;

require_once '../../../server.php';

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = md5($_POST['password']);
$phone    = $_POST['phone'];
$address  = $_POST['address'];

$exists = \App\Models\User::instance()->raw("SELECT * FROM users WHERE email = ?", [$email])->fetch(PDO::FETCH_OBJ);

if ($exists) {

    Session::put("errors", [
        "auth" => "Email sudah terdaftar",
    ]);

    redirect($routes['auth.registration.index']);
}

$user = \App\Models\User::instance()->create([
    "name" => $name,
    "email" => $email,
    "password" => $password,
    "role" => \App\Models\User::ROLE_CUSTOMER,
]);

\App\Models\Biodata::instance()->create([
    "phone" => $phone,
    "address" => $address,
    "user_id" => $user->id,
    "avatar" => str_random(15),
]);

Session::put("success", [
    "auth" => "Berhasil membuat akun, silakan melakukan login",
]);

redirect($routes['auth.login.index']);
