<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
        $rooms = \App\Models\Room::instance()->with('image')->getAll();

        $bookings   = [];
        $rooms      = [];
        $payments   = [];
        $roomImages = [];
        $users      = [];

        if (count(array_intersect(['from', 'to'], array_keys($_GET))) == 2) {
            $bookings = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE DATE(start_date) >= ? AND DATE(end_date) <= ? ORDER BY id DESC", [$_GET['from'], $_GET['to']])->fetchAll();
        } else {
            $bookings = \App\Models\Booking::instance()->raw("SELECT * FROM bookings ORDER BY id DESC")->fetchAll();
        }

        if (count($bookings) > 0) {
            $rooms      = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id IN (" . join(', ', array_column($bookings, 'room_id')) . ")")->fetchAll();
            $payments   = \App\Models\Payment::instance()->raw("SELECT * FROM payments WHERE booking_id IN (" . join(', ', array_column($bookings, 'id')) . ")")->fetchAll();
            $users      = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id IN (" . join(', ', array_column($bookings, 'user_id')) . ")")->fetchAll();

            if (count($rooms) > 0) {
                $roomImages = \App\Models\RoomImage::instance()->raw("SELECT * FROM room_images WHERE room_id IN (" . join(', ', array_column($rooms, 'id')) . ")")->fetchAll();
            }
        }

    ?>
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">

        <?php require_once '../layout/admin/header.php'; ?>
        <?php require_once '../layout/admin/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Order</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Order</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Order</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-12">
                                                <form class="row mb-5">
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="">Dari</label>
                                                            <input type="date" name="from" value="<?= @$_GET['from']; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="">Sampai</label>
                                                            <input type="date" name="to" value="<?= @$_GET['to']; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button class="btn btn-primary">Filter</button>
                                                    </div>
                                                </form>
                                                <table class="table table-bordered table-md dataTable" id="table-1">
                                                    <thead>
                                                    <tr>
                                                        <th>Kamar</th>
                                                        <th>Foto</th>
                                                        <th>Nama Pemesan</th>
                                                        <th>Tanggal Pemesanan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
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

                                                                $user = array_filter($users, function ($user) use ($booking) {
                                                                    return $user['id'] == $booking['user_id'];
                                                                });

                                                                $payment = reset($payment);
                                                                $room    = reset($room);
                                                                $user    = reset($user);

                                                                $image = array_filter($roomImages, function ($image) use ($room) {
                                                                    return $image['room_id'] == $room['id'];
                                                                });

                                                                $image = reset($image);
                                                            ?>

                                                            <tr>
                                                                <td><?= $room['name']; ?> - <?= $room['room_number']; ?></td>
                                                                <td>
                                                                    <img src="<?= asset('uploads/images/rooms/' . $image['name']); ?>" alt="" style="width: 150px; height: 150px;">
                                                                </td>
                                                                <td><?= $user['name']; ?></td>
                                                                <td><?= date('d F Y', strtotime($booking['start_date'])); ?> - <?= date('d F Y', strtotime($booking['end_date'])); ?></td>
                                                                <td>
                                                                    <?php if ($booking['status'] == \App\Models\Booking::STATUS_NOT_ACC): ?>
                                                                        <span class="badge badge-primary">Belum di acc</span>
                                                                    <?php elseif ($booking['status'] == \App\Models\Booking::STATUS_ACC): ?>
                                                                        <span class="badge badge-success">Di acc</span>
                                                                    <?php elseif ($booking['status'] == \App\Models\Booking::STATUS_REJECTED): ?>
                                                                        <span class="badge badge-danger">Di tolak</span>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-danger">Dibatalkan</span>
                                                                    <?php endif; ?>

                                                                    <?php if (!$payment): ?>
                                                                        <span class="badge badge-dark">Belum dibayar</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?= route('admin.orders.show') . '?' . http_build_query(['booking_id' => $booking['id'], 'room_id' => $room['id']]); ?>" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                                                    <?php if ($booking['status'] == \App\Models\Booking::STATUS_NOT_ACC): ?>

                                                                        <?php
                                                                            $query = [
                                                                                'booking_id' => $booking['id'],
                                                                            ];

                                                                            if (count(array_intersect(['from', 'to'], array_keys($_GET))) == 2) {
                                                                                $query = array_merge($query, [
                                                                                    'from' => $_GET['from'],
                                                                                    'to' => $_GET['to']
                                                                                ]);
                                                                            }
                                                                        ?>

                                                                        <button data-title="Terima" data-url="<?= route('admin.orders.update') . '?' . http_build_query(array_merge($query, ['status' => 1])); ?>" data-toggle="modal" data-target="#order-modal" class="btn btn-success btn-accepted"><i class="fa fa-check"></i></button>
                                                                        <button data-title="Tolak" data-url="<?= route('admin.orders.update') . '?' . http_build_query(array_merge($query, ['status' => 3])); ?>" data-toggle="modal" data-target="#order-modal" class="btn btn-danger btn-rejected"><i class="fa fa-times"></i></button>
                                                                    <?php endif; ?>
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
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="order-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="modal-content" method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-text"></p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Iya</button>
                    </div>
                </form>
            </div>
        </div>

        <?php require_once '../layout/admin/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/admin/script.php'; ?>
<script>
    function handleModal(element) {
        var title = $(element).data('title');
        var url   = $(element).data('url');

        $('.modal-title').html(title);
        $('.modal-text').html(title + ' Order ?');
        $('#order-modal form').attr('action', url);
    }

    function handleButton(btnClass) {
        $('#table-1').on('click', btnClass, function () {
            handleModal(this);
        })
    }

    handleButton('.btn-accepted');
    handleButton('.btn-rejected');
</script>
</body>
</html>