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

<div class="d-flex justify-content-around ml-2">
    <div style="background: red">
        <img src="../../assets/img/logo.jpeg" alt="" style="width: 200px; height: 200px;">
    </div>
    <div class="d-flex align-items-center flex-grow-1 ml-3">
        <span style="font-size: 24px;">
            <span>Alamat: Jl. Ir. Sutami, Kemenuh, Kec. Sukawati, Kabupaten Gianyar, Bali 80582</span> <br>
            <span>Telepon: (+62) 887 315 4257</span>
        </span>
    </div>
</div>

<hr>

<h2 class="text-center my-4">
    Laporan Pendapatan Villa Yana Kemenuh
    <?php if (array_key_exists('start_date', $_GET) && array_key_exists('end_date', $_GET)): ?>
        Periode <?= date('d F Y', strtotime($_GET['start_date'])); ?> - <?= date('d F Y', strtotime($_GET['end_date'])); ?>
    <?php endif; ?>
</h2>

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