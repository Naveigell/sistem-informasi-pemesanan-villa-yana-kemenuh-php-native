<?php

require_once '../../server.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout › Top Navigation — Stisla</title>

    <?php require_once '../layout/customer/style.php'; ?>
    <?php
        $bookings = \App\Models\Booking::instance()->raw('SELECT * FROM bookings WHERE user_id = ?', [\Lib\Session\Session::get('user')['id']])->fetchAll();

        $rooms = $payments = $roomImages = [];

        if (count($bookings) > 0) {
            $rooms    = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id IN (" . join(', ', array_column($bookings, 'room_id')) . ")")->fetchAll();
            $payments = \App\Models\Payment::instance()->raw("SELECT * FROM payments WHERE booking_id IN (" . join(', ', array_column($bookings, 'id')) . ")")->fetchAll();

            $roomImages = \App\Models\RoomImage::instance()->raw("SELECT * FROM room_images WHERE room_id IN (" . join(', ', array_column($rooms, 'id')) . ")")->fetchAll();
        }

    ?>
</head>

<body class="layout-3">
<div id="app">
    <div class="main-wrapper container">

        <?php require_once '../layout/customer/header.php'; ?>

        <!-- Main Content -->
        <div class="main-content" style="min-height: 670px;">
            <section class="section">
                <div class="section-body">
                    <h2 class="section-title">Pesanan</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>List Pesanan</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Kamar</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bookings as $index => $booking): ?>

                                                <?php
                                                    $room = array_filter($rooms, function ($room) use ($booking) {
                                                        return $room['id'] == $booking['room_id'];
                                                    });

                                                    $payment = array_filter($payments, function ($payment) use ($booking) {
                                                        return $payment['booking_id'] == $booking['id'];
                                                    });

                                                    $payment = reset($payment);
                                                    $room = reset($room);

                                                    $image = array_filter($roomImages, function ($image) use ($room) {
                                                        return $image['room_id'] == $room['id'];
                                                    });

                                                    $image = reset($image);
                                                ?>

                                                <tr>
                                                    <th scope="row"><?= $index + 1; ?></th>
                                                    <td><img src="<?= asset('/uploads/images/rooms/' . $image['name']); ?>" style="width: 150px; height: 150px;" alt="" class=""></td>
                                                    <td><?= $room['room_number']; ?></td>
                                                    <td><?= date('d F Y', strtotime($booking['start_date'])); ?> - <?= date('d F Y', strtotime($booking['end_date'])); ?></td>
                                                    <td>
                                                        <?php if ($booking['status'] == \App\Models\Booking::STATUS_NOT_ACC): ?>
                                                            <span class="badge badge-primary">Belum di acc</span>
                                                        <?php elseif ($booking['status'] == \App\Models\Booking::STATUS_ACC): ?>
                                                            <span class="badge badge-success">Di acc</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger">Dibatalkan</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                                        <a href="<?= route('customers.orders.complaints.index') . '?' . http_build_query(['booking_id' => $booking['id'], 'room_id' => $booking['room_id']]); ?>" class="btn btn-danger"><i class="fa fa-envelope"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require_once '../layout/customer/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/customer/script.php'; ?>

</body>
</html>


