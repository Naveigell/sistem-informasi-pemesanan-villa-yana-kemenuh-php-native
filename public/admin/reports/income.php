<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../../server.php'; ?>
    <?php require_once "../../layout/admin/style.php"; ?>

    <?php
        $sql = "SELECT * FROM bookings WHERE status = 1";
        $bindings = [];

        if (@$_GET['start_date'] && @$_GET['end_date']) {
            $sql .= " AND DATE(start_date) >= ? AND DATE(end_date) <= ?";
            $bindings = [$_GET['start_date'], $_GET['end_date']];
        }

        $bookings = \App\Models\Booking::instance()->raw($sql, $bindings)->fetchAll();

        $payments = $rooms = [];

        if ($bookings) {
            $payments = \App\Models\Payment::instance()->raw("SELECT * FROM payments WHERE booking_id IN (" . join(', ', array_column($bookings, 'id')) . ")")->fetchAll();
            $rooms    = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id IN (" . join(', ', array_column($bookings, 'room_id')) . ")")->fetchAll();
        }
    ?>
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">

        <?php require_once '../../layout/admin/header.php'; ?>
        <?php require_once '../../layout/admin/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Laporan</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Laporan</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Laporan</h4>
                                </div>
                                <div class="card-body">
                                    <form class="row p-1 mb-4" action="<?= route('admin.reports.incomes.index'); ?>">
                                        <div class="col-3">
                                            <label for="">Tanggal Mulai</label>
                                            <input type="date" class="form-control" name="start_date" value="<?= @$_GET['start_date'] ? date('Y-m-d', strtotime($_GET['start_date'])) : ''; ?>">
                                        </div>
                                        <div class="col-3">
                                            <label for="">Tanggal Selesai</label>
                                            <input type="date" class="form-control" name="end_date" value="<?= @$_GET['end_date'] ? date('Y-m-d', strtotime($_GET['end_date'])) : ''; ?>">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button class="btn btn-primary">Filter</button>
                                            <a href="<?= route('admin.reports.incomes.print.index') . '?' . http_build_query($_GET); ?>" class="btn btn-success">Cetak</a>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-bordered table-md dataTable" id="table-1">
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
                                                            ?>

                                                            <tr>
                                                                <td><?= $index + 1; ?></td>
                                                                <td><?= $room['name']; ?></td>
                                                                <td><?= date('d F Y', strtotime($booking['start_date'])); ?> - <?= date('d F Y', strtotime($booking['end_date'])); ?></td>
                                                                <td><?= format_currency($room['price']); ?></td>
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

        <?php require_once '../../layout/admin/footer.php'; ?>

    </div>
</div>

<?php require_once '../../layout/admin/script.php'; ?>
</body>
</html>