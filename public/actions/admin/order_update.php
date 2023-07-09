<?php

require_once '../../../server.php';

$bookingId = $_GET['booking_id'];
$status    = $_GET['status'];

\App\Models\Booking::instance()->raw("UPDATE bookings SET status = ? WHERE id = ?", [$status, $bookingId]);

$query = [
    'booking_id' => $bookingId,
    'status' => $status,
];

if (count(array_intersect(['from', 'to'], array_keys($_GET))) == 2) {
    $query = array_merge($query, [
        'from' => $_GET['from'],
        'to' => $_GET['to']
    ]);
}

if ($status == \App\Models\Booking::STATUS_ACC) {
    $booking = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE id = ?", [$bookingId])->fetch();

    \App\Models\Complaint::instance()->create([
        "booking_id" => $bookingId,
        "room_id" => $booking['room_id'],
    ]);
}

redirect($routes['admin.orders.index'] . '?' . http_build_query($query));