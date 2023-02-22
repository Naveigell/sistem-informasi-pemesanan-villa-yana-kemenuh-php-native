<?php

require_once '../../../server.php';

\App\Models\Booking::instance()->raw("UPDATE bookings SET status = ? WHERE id = ?", [\App\Models\Booking::STATUS_CANCELED, $_GET['booking_id']]);

redirect($routes['customers.orders.index']);