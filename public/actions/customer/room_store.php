<?php

require_once '../../../server.php';

$name      = $_POST['name'];
$phone     = $_POST['phone'];
$address   = $_POST['address'];
$email     = $_POST['email'];
$roomId    = $_POST['room_id'];
$startDate = $_POST['start_date'];
$endDate   = $_POST['end_date'];

$booking = \App\Models\Booking::instance()->create([
    "start_date" => $startDate,
    "end_date"   => $endDate,
    "room_id"    => $roomId,
    "user_id"    => \Lib\Session\Session::get('user')['id'],
    "name"       => $name,
    "email"      => $email,
    "phone"      => $phone,
    "address"    => $address,
]);

redirect($routes['rooms.payment.detail'] . '?' . http_build_query(["room_id" => $roomId, "booking_id" => $booking->id]));