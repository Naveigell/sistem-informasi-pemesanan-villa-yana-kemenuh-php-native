<?php

require_once 'server.php';

\App\Models\User::instance()->create([
    "name" => "admin",
    "email" => "admin@gmail.com",
    "password" => md5(123456),
    "role" => \App\Models\User::ROLE_ADMIN,
]);

\App\Models\User::instance()->create([
    "name" => "staff",
    "email" => "staff@gmail.com",
    "password" => md5(123456),
    "role" => \App\Models\User::ROLE_STAFF,
]);

times(3, function () {
    $rand = mt_rand(1, 9000);

    \App\Models\User::instance()->create([
        "name" => "staff{$rand}",
        "email" => "staff{$rand}@gmail.com",
        "password" => md5(123456),
        "role" => \App\Models\User::ROLE_STAFF,
    ]);
});

$customer = \App\Models\User::instance()->create([
    "name" => "customer",
    "email" => "customer@gmail.com",
    "password" => md5(123456),
    "role" => \App\Models\User::ROLE_CUSTOMER,
]);

\App\Models\Biodata::instance()->create([
    "user_id" => $customer->id,
    "phone" => "1234567890",
    "address" => "lorem ipsum dolor sit amet",
]);

times(15, function () {
    $rand = mt_rand(1, 9000);

    $user = \App\Models\User::instance()->create([
        "name" => "customer{$rand}",
        "email" => "customer{$rand}@gmail.com",
        "password" => md5(123456),
        "role" => \App\Models\User::ROLE_CUSTOMER,
    ]);

    \App\Models\Biodata::instance()->create([
        "user_id" => $user->id,
        "phone" => "1234567890",
        "address" => "lorem ipsum dolor sit amet",
    ]);
});

times(1, function () {

    $roomNames = ['Anyelir', 'Anggrek', 'Cempaka', 'Jempiring', 'Sandat', 'Jepun'];

    foreach ($roomNames as $roomName) {
        $number = mt_rand(1, 100);
        $number = str_pad($number, 3, "0", STR_PAD_LEFT);

        $number = str_random(3) . '_' . $number;

        $room = \App\Models\Room::instance()->create([
            "room_number" => $number,
            "name"        => $roomName,
            "price"       => 700000,
            "description" => "Kamar {$roomName} menyediakan berbagai fasilitas terbaik. Anda bisa langsung memesan kamar",
        ]);

        times(1, function ($index) use ($room) {

            if (!file_exists('./public/uploads/images/rooms')) {
                mkdir('./public/uploads/images/rooms', 0777, true);
            }

            if (!file_exists('./public/uploads/images/payments')) {
                mkdir('./public/uploads/images/payments', 0777, true);
            }

            foreach (range(13, 6) as $index) {
                $name = \Ramsey\Uuid\Uuid::uuid4() . ".jpeg";

                copy("./public/assets/img/dummies/{$index}.jpeg", './public/uploads/images/rooms/' . $name);

                \App\Models\RoomImage::instance()->create([
                    "room_id" => $room->id,
                    "name"    => $name,
                    "is_main" => $index == 6 ? 1 : 0,
                ]);
            }
        });

        $facilities = [
            "Lemari", "TV", "Wifi", "Sikat Gigi", "Sampo", "Conditioner", "Sabun",
        ];

        times(1, function () use ($room, $facilities) {

            foreach ($facilities as $facility) {
                \App\Models\Facility::instance()->create([
                    "room_id" => $room->id,
                    "name"    => $facility,
                ]);
            }
        });
    }
});

times(1, function () {
    $rooms    = \App\Models\Room::instance()->raw("SELECT id FROM rooms")->fetchAll();
    $roomIds  = array_column($rooms, 'id');
    $users    = \App\Models\User::instance()->raw("SELECT id, name, email FROM users WHERE role = 'customer'")->fetchAll();
    $biodatas = \App\Models\Biodata::instance()->raw("SELECT * FROM biodatas")->fetchAll();
    $userIds  = array_column($users, 'id');

    times(count($roomIds), function ($index) use ($roomIds, $userIds, $users, $biodatas) {

        times(rand(3, 5), function () use ($index, $roomIds, $userIds, $users, $biodatas) {

            $startDate = strtotime(date('Y-m-d'));
            $endDate   = date("Y-m-d", strtotime("+" . rand(1, 6) . " day", $startDate));

            $booking = \App\Models\Booking::instance()->create([
                "room_id"    => $roomIds[$index],
                "user_id"    => $userIds[array_rand($userIds)],
                "name"       => $users[array_rand($users)]['name'],
                "email"      => $users[array_rand($users)]['email'],
                "phone"      => $biodatas[array_rand($biodatas)]['phone'],
                "address"    => $biodatas[array_rand($biodatas)]['address'],
                "start_date" => date('Y-m-d', $startDate),
                "end_date"   => $endDate,
                "status"     => rand(0, 1),
            ]);

            $name = str_random(40) . ".jpg";

            copy('./public/assets/img/bukti-pembayaran.png', './public/uploads/images/payments/' . $name);

            \App\Models\Payment::instance()->create([
                "room_id"    => $roomIds[$index],
                "booking_id" => $booking->id,
                "proof"      => $name,
            ]);
        });
    });
});

times(1, function () {
    $bookings = \App\Models\Booking::instance()->getAll();
    $rooms    = \App\Models\Room::instance()->getAll();
    $users    = \App\Models\User::instance()->raw("SELECT * FROM users WHERE role = ?", [\App\Models\User::ROLE_CUSTOMER])->fetchAll(PDO::FETCH_OBJ);

    times(30, function () use ($bookings, $rooms, $users) {
        $types = [\App\Models\Complaint::COMPLAINT_TYPE_CUSTOMER, \App\Models\Complaint::COMPLAINT_TYPE_ADMIN];
        $descriptions = ['Keran air bocor', 'Wastafel bocor', 'Genteng bocor', 'Kemalingan sepatu'];

        \App\Models\Complaint::instance()->create([
            "user_id"        => $users[array_rand($users)]->id,
            "room_id"        => $rooms[array_rand($rooms)]->id,
            "booking_id"     => $bookings[array_rand($bookings)]->id,
            "complaint_type" => $types[array_rand($types)],
            "description"    => $descriptions[array_rand($descriptions)],
            "status"         => rand(0, 1)
        ]);
    });
});

times(5, function () {
    \App\Models\Testimonial::instance()->create([
        "name"        => str_random(40),
        "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, aut beatae earum, eius eum ex expedita fugiat maiores, minima modi quaerat quod quos rerum similique ullam. Architecto maxime nemo porro!",
        "star"        => rand(1, 5),
    ]);
});