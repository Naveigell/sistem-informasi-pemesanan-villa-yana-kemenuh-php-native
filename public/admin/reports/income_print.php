<?php

require_once '../../../server.php';
require_once "../../layout/admin/style.php";

$sql = "SELECT * FROM bookings WHERE status = 1";
$bindings = [];

if (@$_GET['start_date'] && @$_GET['end_date']) {
    $sql .= " AND DATE(start_date) >= ? AND DATE(end_date) <= ?";
    $bindings = [$_GET['start_date'], $_GET['end_date']];
}

$bookings = \App\Models\Booking::instance()->raw($sql, $bindings)->fetchAll();

$total = 0;
$payments = $rooms = [];

if ($bookings) {
    $payments = \App\Models\Payment::instance()->raw("SELECT * FROM payments WHERE booking_id IN (" . join(', ', array_column($bookings, 'id')) . ")")->fetchAll();
    $rooms    = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id IN (" . join(', ', array_column($bookings, 'room_id')) . ")")->fetchAll();
}

?>

<table class="table table-bordered table-md" id="table-1">
    <thead>
    <tr>
        <th class="col-1">#</th>
        <th>Nama Kamar</th>
        <th>Tanggal Sewa</th>
        <th>Harga</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($bookings as $index => $booking): ?>

        <?php
            $room = array_filter($rooms, function ($room) use ($booking) {
                return $room['id'] == $booking['room_id'];
            });

            $room = reset($room);

            $total += $room['price'];
        ?>

        <tr>
            <td><?= $index + 1; ?></td>
            <td><?= $room['name']; ?></td>
            <td><?= date('d F Y', strtotime($booking['start_date'])); ?> - <?= date('d F Y', strtotime($booking['end_date'])); ?></td>
            <td><?= format_currency($room['price']); ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3">Total</td>
        <td colspan="1"><?= format_currency($total); ?></td>
    </tr>
    </tbody>
</table>
<script>
    window.print();
</script>