<?php

require_once '../../../server.php';

$bookingId   = $_GET['booking_id'];
$roomId      = $_GET['room_id'];
$description = $_POST['description'];

\App\Models\Complaint::instance()->create([
    "user_id"        => \Lib\Session\Session::get('user')['id'],
    "room_id"        => $roomId,
    "booking_id"     => $bookingId,
    "complaint_type" => \App\Models\Complaint::COMPLAINT_TYPE_CUSTOMER,
    "description"    => $description,
]);

redirect($routes['customers.orders.index']);