<?php

require_once '../../../server.php';

$bookingId = $_GET['booking_id'];
$status    = $_GET['status'];

\App\Models\Booking::instance()->raw("UPDATE bookings SET status = ? WHERE id = ?", [$status, $bookingId]);

redirect($routes['admin.orders.index'] . '?' . http_build_query(['from' => $_GET['from'], 'to' => $_GET['to']]));