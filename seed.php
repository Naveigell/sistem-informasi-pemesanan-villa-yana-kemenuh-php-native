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

    $user = \App\Models\User::instance()->create([
        "email" => "customer{$rand}@gmail.com",
        "password" => password_hash(123456, PASSWORD_BCRYPT),
        "role" => \App\Models\User::ROLE_CUSTOMER,
    ]);

    \App\Models\Biodata::instance()->create([
        "user_id" => $user->id,
        "phone" => "1234567890",
        "address" => "lorem ipsum dolor sit amet",
    ]);
});

times(5, function () {
    $number = mt_rand(1, 100);
    $number = str_pad($number, 3, "0", STR_PAD_LEFT);

    $number = str_random(3) . '_' . $number;

    $room = \App\Models\Room::instance()->create([
        "room_number" => $number,
        "name"        => str_random(40),
        "price"       => mt_rand(1, 7) * (10 ** mt_rand(5, 8)),
        "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, aut beatae earum, eius eum ex expedita fugiat maiores, minima modi quaerat quod quos rerum similique ullam. Architecto maxime nemo porro!",
    ]);

    times(mt_rand(2, 4), function () use ($room) {
        $name = str_random(40) . ".jpg";

        if (!file_exists('./public/uploads/images/rooms')) {
            mkdir('./public/uploads/images/rooms', 0777, true);
        }

        copy('./public/assets/img/villa-room-template.jpeg', './public/uploads/images/rooms/' . $name);

        \App\Models\RoomImage::instance()->create([
            "room_id" => $room->id,
            "name"    => $name,
        ]);
    });

    times(mt_rand(2, 6), function () use ($room) {

        $facilities = ["Tempat Tidur", "Kipas Angin", "AC", "Kompor"];

        \App\Models\Facility::instance()->create([
            "room_id" => $room->id,
            "name"    => $facilities[array_rand($facilities)],
        ]);
    });
});