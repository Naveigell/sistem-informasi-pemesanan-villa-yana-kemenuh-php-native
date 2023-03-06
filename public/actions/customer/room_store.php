<?php

require_once '../../../server.php';

$name      = $_POST['name'];
$phone     = $_POST['phone'];
$address   = $_POST['address'];
$roomId    = $_POST['room_id'];
$startDate = $_POST['start_date'];
$endDate   = $_POST['end_date'];
$proof     = $_FILES['proof'];

$filename = str_random(40) . ".jpg";

if (move_uploaded_file($proof['tmp_name'], "../../uploads/images/payments/" . $filename)) {

    $booking = \App\Models\Booking::instance()->create([
        "start_date" => $startDate,
        "end_date"   => $endDate,
        "room_id"    => $roomId,
        "user_id"    => \Lib\Session\Session::get('user')['id'],
    ]);

    \App\Models\Payment::instance()->create([
        "room_id"    => $roomId,
        "booking_id" => $booking->id,
        "proof"      => $filename,
    ]);

    redirect($routes['home.index']);
}