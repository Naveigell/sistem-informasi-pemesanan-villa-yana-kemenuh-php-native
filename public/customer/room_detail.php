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
        $images     = \App\Models\RoomImage::instance()->raw("SELECT * FROM room_images WHERE room_id = ? ORDER BY is_main", [$_GET['room_id']])->fetchAll(PDO::FETCH_OBJ);
        $room       = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id = ?", [$_GET['room_id']])->fetch(PDO::FETCH_OBJ);
        $facilities = \App\Models\Facility::instance()->raw("SELECT * FROM facilities WHERE room_id = ?", [$_GET['room_id']])->fetchAll(PDO::FETCH_OBJ);

        $from   = $_GET['from'] ?? null;
        $to     = $_GET['to'] ?? null;
        $roomId = $_GET['room_id'] ?? null;

        $isBooked = false;

        if ($from && $to && $roomId) {
            $booking = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE room_id = ? AND DATE(start_date) >= ? AND DATE(end_date) <= ?", [$roomId, $from, $to])->fetch(PDO::FETCH_OBJ);

            $isBooked = $booking != false; // if booking not false
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
                    <h2 class="section-title">Detail Kamar</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Foto Kamar</h4>
                                </div>
                                <div class="card-body">
                                    <div id="carouselRoomImage" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <?php foreach ($images as $index => $image): ?>
                                                <li data-target="#carouselRoomImage" data-slide-to="<?= $index; ?>" class="<?= $index == 0 ? 'active' : ''; ?>"></li>
                                            <?php endforeach; ?>
                                        </ol>
                                        <div class="carousel-inner">
                                            <?php foreach ($images as $index => $image): ?>
                                                <div class="carousel-item <?= $index == 0 ? 'active' : ''; ?>">
                                                    <img class="d-block w-100" src="../uploads/images/rooms/<?= $image->name; ?>" style="height: 550px !important;">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselRoomImage" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselRoomImage" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
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
                                    </div>
                                    <div class="" style="padding-top: 0px !important;">
                                        <form action="<?= route('rooms.detail'); ?>" class="" method="get">
                                            <h6>Cek Ketersedian</h6>
                                            <?php if ($isBooked): ?>
                                                <div class="alert alert-danger">Sudah ada yang memesan.</div>
                                            <?php endif; ?>
                                            <input type="hidden" name="room_id" value="<?= $_GET['room_id']; ?>">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group mb-0">
                                                        <label>Dari</label>
                                                        <input name="from" type="date" value="<?= @$_GET['from'] ? date('Y-m-d', strtotime($_GET['from'])) : ''; ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group mb-0">
                                                        <label>Sampai</label>
                                                        <input name="to" type="date" value="<?= @$_GET['to'] ? date('Y-m-d', strtotime($_GET['to'])) : ''; ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="form-group mb-0">
                                                        <button type="submit" class="btn btn-primary">Cek</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <?php if ($from && $to && !$isBooked && $roomId): ?>
                                            <div class="row mt-4">
                                                <div class="alert alert-success col-12">Kamar dapat dipesan.</div>
                                                <form action="<?= route('rooms.bookings.store'); ?>" class="col-lg-8 col-md-12" method="post" enctype="multipart/form-data">
                                                    <h6 class="text text-success">Form Pemesanan</h6>
                                                    <input type="hidden" name="room_id" value="<?= $_GET['room_id']; ?>">
                                                    <input type="hidden" name="start_date" value="<?= $_GET['from']; ?>">
                                                    <input type="hidden" name="end_date" value="<?= $_GET['to']; ?>">
                                                    <div class="form-group">
                                                        <label for="">Nama</label>
                                                        <input type="text" name="name" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Alamat</label>
                                                        <input type="text" name="address" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="email" name="email" class="form-control" value="<?= \Lib\Session\Session::get('user')['email']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">No Telp</label>
                                                        <input type="text" name="phone" class="form-control">
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
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


