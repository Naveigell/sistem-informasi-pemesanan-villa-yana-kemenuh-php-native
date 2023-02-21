<?php

require_once '../../../server.php';

$name    = $_POST['name'];
$email   = $_POST['email'];
$address = $_POST['address'];
$phone   = $_POST['phone'];

if (\Lib\Session\Session::get('user')['email'] != $email) {

    $exists = \App\Models\User::instance()->raw("SELECT * FROM users WHERE email = ?", [$email])->fetch();

    if ($exists) {
        redirect($routes['customers.profile.index']);
    }

}

\App\Models\User::instance()->raw("UPDATE users SET name = ?, email = ? WHERE id = ?", [$name, $email, \Lib\Session\Session::get('user')['id']]);
\App\Models\Biodata::instance()->raw("UPDATE biodatas SET phone = ?, address = ? WHERE user_id = ?", [$phone, $address, \Lib\Session\Session::get('user')['id']]);

$u = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id = ?", [\Lib\Session\Session::get('user')['id']])->fetch();

\Lib\Session\Session::put('user', $u);

redirect($routes['customers.profile.index']);