<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>
    <?php
        $complaints = \App\Models\Complaint::instance()->raw("SELECT * FROM complaints")->fetchAll();

        $rooms    = [];
        $users    = [];
        $bookings = [];

        if (count($complaints) > 0) {
            $rooms    = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id IN (" . join(', ', array_column($complaints, 'room_id')) . ")")->fetchAll();
            $users    = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id IN (" . join(', ', array_column($complaints, 'user_id')) . ")")->fetchAll();
            $bookings = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE id IN (" . join(', ', array_column($complaints, 'booking_id')) . ")")->fetchAll();
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
                    <h1>Komplain</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Komplain</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Komplain</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-md dataTable" id="table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nomor Kamar</th>
                                            <th>Nama Pemesan</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Deskripsi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($complaints as $index => $complaint): ?>

                                                <?php
                                                    $room = array_filter($rooms, function ($room) use ($complaint) {
                                                        return $room['id'] == $complaint['room_id'];
                                                    });

                                                    $user = array_filter($users, function ($user) use ($complaint) {
                                                        return $user['id'] == $complaint['user_id'];
                                                    });

                                                    $booking = array_filter($bookings, function ($booking) use ($complaint) {
                                                        return $booking['id'] == $complaint['booking_id'];
                                                    });

                                                    $booking = reset($booking);
                                                    $room    = reset($room);
                                                    $user    = reset($user);
                                                ?>

                                                <tr>
                                                    <td><?= $index + 1; ?></td>
                                                    <td><?= $room['room_number']; ?></td>
                                                    <td><?= $user['name']; ?></td>
                                                    <td><?= date('d F Y', strtotime($booking['start_date'])); ?> - <?= date('d F Y', strtotime($booking['end_date'])); ?></td>
                                                    <td><?= $complaint['description']; ?></td>
                                                    <td>
                                                        <?php if ($complaint['status'] == \App\Models\Complaint::COMPLAINT_STATUS_NOT_FINISHED): ?>
                                                            <span class="badge badge-light">Sedang di proses</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-success">Selesai</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($complaint['status'] == \App\Models\Complaint::COMPLAINT_STATUS_NOT_FINISHED): ?>
                                                            <button data-url="<?= route('admin.complaints.update') . '?' . http_build_query(['complaint_id' => $complaint['id']]); ?>" data-toggle="modal" data-target="#complaint-finish-modal" class="btn btn-success btn-accepted"><i class="fa fa-check"></i></button>
                                                        <?php else: ?>
                                                            -
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
            </section>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="complaint-finish-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="modal-content" method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Selesai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-text">Selesaikan komplain?</p>
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
    $('#table-1').on('click', '.btn-accepted', function () {
        $('#complaint-finish-modal form').attr('action', $(this).data('url'));
    })
</script>
</body>
</html>