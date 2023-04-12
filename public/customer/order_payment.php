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
                                <div class="card-body">
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
                                        <h6>Upload Bukti Pembayaran</h6>
                                        <div class="row mt-4">
                                            <form action="<?= route('rooms.bookings.payment.store'); ?>" class="col-lg-8 col-md-12" method="post" enctype="multipart/form-data">
                                                <div class="alert alert-light">
                                                    Silakan melakukan pembayaran ke nomor rekening berikut :
                                                    <ul>
                                                        <?php foreach (PAYMENT_CARD_ACCOUNT as $account => $array): ?>
                                                            <li><?= $account; ?> (<?= strtoupper($array['bank_type']); ?>) - <?= $array['account_name']; ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                                <h6 class="text text-success">Form Pembayaran</h6>
                                                <div class="form-group">
                                                    <label for="">Bukti Pembayaran</label>
                                                    <input type="hidden" name="room_id" value="<?= $_GET['room_id']; ?>">
                                                    <input type="hidden" name="booking_id" value="<?= $_GET['booking_id']; ?>">
                                                    <input type="file" name="proof" class="form-control" accept="image/png,image/jpeg,image/jpg">
                                                </div>

                                                <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
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


