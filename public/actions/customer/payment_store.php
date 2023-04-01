<?php

require_once '../../../server.php';

$roomId    = $_POST['room_id'];
$bookingId = $_POST['booking_id'];
$proof     = $_FILES['proof'];

$filename = str_random(40) . ".jpg";

if (move_uploaded_file($proof['tmp_name'], "../../uploads/images/payments/" . $filename)) {

    \App\Models\Payment::instance()->create([
        "room_id"    => $roomId,
        "booking_id" => $bookingId,
        "proof"      => $filename,
    ]);

    redirect($routes['home.index']);
}