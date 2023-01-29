<?php

require_once 'server.php';

\App\Models\User::instance()->create([
    "email" => "admin@gmail.com",
    "password" => password_hash(123456, PASSWORD_BCRYPT),
    "role" => \App\Models\User::ROLE_ADMIN,
]);

\App\Models\User::instance()->create([
    "email" => "staff@gmail.com",
    "password" => password_hash(123456, PASSWORD_BCRYPT),
    "role" => \App\Models\User::ROLE_STAFF,
]);

times(3, function () {
    $rand = mt_rand(1, 9000);

    \App\Models\User::instance()->create([
        "email" => "staff{$rand}@gmail.com",
        "password" => password_hash(123456, PASSWORD_BCRYPT),
        "role" => \App\Models\User::ROLE_STAFF,
    ]);
});

\App\Models\User::instance()->create([
    "email" => "customer@gmail.com",
    "password" => password_hash(123456, PASSWORD_BCRYPT),
    "role" => \App\Models\User::ROLE_CUSTOMER,
]);

times(15, function () {
    $rand = mt_rand(1, 9000);

    \App\Models\User::instance()->create([
        "email" => "customer{$rand}@gmail.com",
        "password" => password_hash(123456, PASSWORD_BCRYPT),
        "role" => \App\Models\User::ROLE_CUSTOMER,
    ]);
});