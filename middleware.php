<?php

$date = date_create(date('d-m-Y'));
$date = date_add($date, date_interval_create_from_date_string('2 days'));
$date = date('Y-m-d', $date->getTimestamp());

$statusNotAcc = \App\Models\Booking::STATUS_NOT_ACC;

// DELETE BOOKING IF THERE IS NO PAYMENT WITHIN 2 DAYS
\App\Models\Booking::instance()->raw("DELETE FROM bookings WHERE bookings.id IN (
    SELECT id FROM (SELECT * FROM bookings) AS bookings WHERE NOT EXISTS (
        SELECT booking_id FROM payments WHERE bookings.id = payments.booking_id
    ) AND created_at >= '{$date}' AND bookings.status = '{$statusNotAcc}'
)")->execute();