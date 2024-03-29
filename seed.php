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
    "avatar" => str_random(40),
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
        "avatar" => str_random(40),
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

            $day = rand(1, 6);
            $startDate = strtotime(date('Y-m-d'));
            $endDate   = date("Y-m-d", strtotime("+" . $day . " day", $startDate));

            $booking = \App\Models\Booking::instance()->create([
                "room_id"       => $roomIds[$index],
                "user_id"       => $userIds[array_rand($userIds)],
                "identity_card" => str_random(20),
                "name"          => $users[array_rand($users)]['name'],
                "email"         => $users[array_rand($users)]['email'],
                "phone"         => $biodatas[array_rand($biodatas)]['phone'],
                "address"       => $biodatas[array_rand($biodatas)]['address'],
                "start_date"    => date('Y-m-d', $startDate),
                "end_date"      => $endDate,
                "total_day"     => $day + 1,
                "status"        => rand(0, 1),
                "down_payment"  => str_random(30),
                "created_at"    => date('Y-m-d'),
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

times(rand(1, 3), function () {
    $startDate = \Carbon\Carbon::parse(date('Y-m-d'))->addDays(rand(10, 13))->toDateString();
    $endDate   = \Carbon\Carbon::parse($startDate)->addDays(rand(10, 15))->toDateString();

    $promos = [\App\Models\Promo::PROMO_TYPE_DISCOUNT, \App\Models\Promo::PROMO_TYPE_INCLUDE];
    $rand = array_rand($promos);
    $type = $promos[$rand];

    \App\Models\Promo::instance()->create([
        "title" => str_random(),
        "description" => "Phasellus massa dui, imperdiet eu aliquet finibus, mollis ac nisi. Duis sagittis vulputate massa vel congue. Aenean commodo, eros quis viverra pulvinar, urna odio hendrerit tortor, vitae tristique lectus arcu quis erat. Nullam blandit neque velit, ac lacinia ligula vehicula sed. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam ipsum lorem, rutrum in lobortis eget, bibendum luctus ligula. Donec lobortis, augue vel sodales pretium, elit neque dignissim nibh, eget euismod est nibh in magna. Suspendisse potenti. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum iaculis neque ac diam varius pretium. Mauris non ligula condimentum, pharetra diam sit amet, sodales nisl. Ut sed vulputate velit. Vestibulum viverra rutrum pellentesque.",
        "type" => $type,
        "price" => $type == \App\Models\Promo::PROMO_TYPE_DISCOUNT ? (10 ** 3) * rand(2, 5) : 0,
        "start_date" => $startDate,
        "end_date" => $endDate,
    ]);
});

times(1, function () {
    $bookings  = \App\Models\Booking::instance()->getAll();
    $customers = \App\Models\User::instance()->raw("SELECT * FROM users WHERE role = ?", [\App\Models\User::ROLE_CUSTOMER])->fetchAll(PDO::FETCH_OBJ);
    $staff     = \App\Models\User::instance()->raw("SELECT * FROM users WHERE role = ?", [\App\Models\User::ROLE_STAFF])->fetchAll(PDO::FETCH_OBJ);

    times(count($bookings), function ($index) use ($bookings, $customers, $staff) {
        $complaint = \App\Models\Complaint::instance()->create([
            "room_id" => $bookings[$index]->room_id,
            "booking_id" => $bookings[$index]->id,
            "status" => \App\Models\Booking::STATUS_ACC,
        ]);

        times(rand(1, 3), function () use ($complaint, $customers) {
            \App\Models\ComplaintDescription::instance()->create([
                "user_id" => $customers[array_rand($customers)]->id,
                "complaint_id" => $complaint->id,
                "image" => rand(0, 1) ? null : str_random(40),
                "description" => str_random(100),
            ]);
        });

        times(rand(1, 2), function () use ($complaint, $staff) {
            \App\Models\ComplaintDescription::instance()->create([
                "user_id" => $staff[array_rand($staff)]->id,
                "complaint_id" => $complaint->id,
                "image" => rand(0, 1) ? null : str_random(40),
                "description" => str_random(100),
            ]);
        });
    });
});

times(5, function () {
    \App\Models\Testimonial::instance()->create([
        "name"        => str_random(40),
        "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, aut beatae earum, eius eum ex expedita fugiat maiores, minima modi quaerat quod quos rerum similique ullam. Architecto maxime nemo porro!",
        "star"        => rand(1, 5),
    ]);
});