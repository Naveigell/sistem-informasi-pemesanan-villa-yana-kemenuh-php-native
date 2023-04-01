<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
        $booking    = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE id = ?", [$_GET['booking_id']])->fetch(PDO::FETCH_OBJ);
        $images     = \App\Models\RoomImage::instance()->raw("SELECT * FROM room_images WHERE room_id = ? ORDER BY is_main", [$_GET['room_id']])->fetchAll(PDO::FETCH_OBJ);
        $room       = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id = ?", [$_GET['room_id']])->fetch(PDO::FETCH_OBJ);
        $facilities = \App\Models\Facility::instance()->raw("SELECT * FROM facilities WHERE room_id = ?", [$_GET['room_id']])->fetchAll(PDO::FETCH_OBJ);
        $user       = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id = ?", [$booking->user_id])->fetch(PDO::FETCH_OBJ);
        $biodata    = \App\Models\Biodata::instance()->raw("SELECT * FROM biodatas WHERE user_id = ?", [$user->id])->fetch(PDO::FETCH_OBJ);
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
                                    <h4>Detail Order</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="row p-3 mt-4">
                                            <h5><?= $room->name; ?></h5>
                                            <div class="col-12 p-0 mt-3">
                                                <p><?= $room->description; ?></p>
                                                <h6>Fasilitas</h6>
                                                <ul style="padding-left: 12px;">
                                                    <?php foreach ($facilities as $facility): ?>
                                                        <li><?= $facility->name; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <h6>Harga Per Malam</h6>
                                                <p><?= format_currency($room->price); ?></p>
                                            </div>

                                            <h3 class="mt-5 d-block col-12">Detail Pemesan</h3>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Nama</label>
                                                    <input disabled type="text" name="name" class="form-control" value="<?= $booking->name; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Alamat</label>
                                                    <input disabled type="text" name="address" class="form-control" value="<?= $booking->address; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input disabled type="email" name="email" class="form-control" value="<?= $booking->email; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">No Telp</label>
                                                    <input disabled type="text" name="phone" class="form-control" value="<?= $booking->phone; ?>">
                                                </div>
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
        <?php require_once '../layout/admin/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/admin/script.php'; ?>
</body>
</html>