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
    $booking = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE id = ?", [$_GET['booking_id']])->fetch();

    $promo = null;

    if ($booking['promo_id']) {
        $promo = \App\Models\Promo::instance()->raw('SELECT * FROM promos WHERE id = ?', [$booking['promo_id']])->fetch(PDO::FETCH_OBJ);
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
                                            <?php if ($promo && $promo->type == \App\Models\Promo::PROMO_TYPE_DISCOUNT): ?>
                                                <p>Promo: <?= format_currency($promo->price); ?></p>
                                                <p>Total: <small><strike><?= format_currency(($room->price * $booking['total_day']) - ($room->price * 0.1)); ?></strike></small>&nbsp;<?= format_currency(max(0, (($room->price * $booking['total_day']) - ($room->price * 0.1)) - $promo->price)); ?> (<?= $booking['total_day']; ?> hari)</p>
                                                <p class="text-small text-muted"><?= format_currency(($room->price * 0.1)); ?> sudah dibayar di awal.</p>
                                            <?php else: ?>
                                                <p>Total: <?= format_currency(($room->price * $booking['total_day']) - ($room->price * 0.1)); ?> (<?= $booking['total_day']; ?> hari)</p>
                                            <?php endif; ?>
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
                                                <?php
                                                    $date = \Carbon\Carbon::parse($booking['created_at'])->addDays(2);
                                                ?>

                                                <input type="hidden" id="time" value="<?= $date->format('Y-m-d H:i'); ?>">
                                                <div class="alert alert-danger">
                                                    Bayar sebelum : <span id="countdown-<?= $booking['id']; ?>"></span>
                                                </div>
                                                <script>
                                                    createCountDown(document.getElementById('time').value, document.getElementById('countdown-<?= $booking["id"]; ?>'));
                                                </script>
                                                <div class="form-group">
                                                    <label for="">Bukti Pembayaran</label>
                                                    <input type="hidden" name="room_id" value="<?= $_GET['room_id']; ?>">
                                                    <input type="hidden" name="booking_id" value="<?= $_GET['booking_id']; ?>">
                                                    <input required type="file" name="proof" class="form-control" accept="image/png,image/jpeg,image/jpg">
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


