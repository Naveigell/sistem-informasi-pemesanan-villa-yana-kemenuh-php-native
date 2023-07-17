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
        $booking    = \App\Models\Booking::instance()->raw('SELECT * FROM bookings WHERE id = ?', [$_GET['booking_id']])->fetch(PDO::FETCH_OBJ);
        $room       = \App\Models\Room::instance()->raw('SELECT * FROM rooms WHERE id = ?', [$booking->room_id])->fetch(PDO::FETCH_OBJ);
        $facilities = \App\Models\Facility::instance()->raw("SELECT * FROM facilities WHERE room_id = ?", [$booking->room_id])->fetchAll(PDO::FETCH_OBJ);
        $promo      = null;

        if ($booking->promo_id) {
            $promo = \App\Models\Promo::instance()->raw("SELECT * FROM promos WHERE id = ?", [$booking->promo_id])->fetch(PDO::FETCH_OBJ);
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
                                                <h6>Sewa dari tanggal : </h6>
                                                <p><?= \Carbon\Carbon::parse($booking->start_date)->format('d F Y'); ?> &nbsp; s/d. &nbsp; <?= \Carbon\Carbon::parse($booking->end_date)->format('d F Y'); ?> (<?= $booking->total_day; ?> hari)</p>
                                                <?php if ($promo && $promo->type == \App\Models\Promo::PROMO_TYPE_DISCOUNT): ?>
                                                    <p>Promo: <?= format_currency($promo->price); ?></p>
                                                    <p>Total: <small><strike><?= format_currency(($room->price * $booking->total_day) - ($room->price * 0.1)); ?></strike></small>&nbsp;<?= format_currency(max(0, (($room->price * $booking->total_day) - ($room->price * 0.1)) - $promo->price)); ?> (<?= $booking->total_day; ?> hari)</p>
                                                <?php elseif ($promo && $promo->type == \App\Models\Promo::PROMO_TYPE_INCLUDE): ?>
                                                    <h6>Total</h6>
                                                    <p><?= format_currency($room->price * $booking->total_day); ?> (<?= $booking->total_day; ?> hari)</p>
                                                    <button data-toggle="modal" data-target="#promo-modal" type="button" class="btn btn-warning" id="button-promo"><i class="fa fa-certificate"></i> Cek Deskripsi Promo</button>
                                                <?php else: ?>
                                                    <h6>Total</h6>
                                                    <p><?= format_currency($room->price * $booking->total_day); ?> (<?= $booking->total_day; ?> hari)</p>
                                                <?php endif; ?>
                                            </div>

                                            <h3 class="mt-5 d-block col-12">Detail Pemesan</h3>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="">Ktp</label>
                                                    <div style="border: 1px dashed #cccccc; border-radius: 5px;">
                                                        <img src="<?= asset('uploads/images/identity_cards/' . $booking->identity_card); ?>" alt="" width="100%" height="100%">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Pembayaran Dp 10%</label>
                                                    <div style="border: 1px dashed #cccccc; border-radius: 5px;">
                                                        <img src="<?= asset('uploads/images/down_payments/' . $booking->down_payment); ?>" alt="" width="100%" height="100%">
                                                    </div>
                                                </div>
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
                                                <?php if ($booking->note): ?>
                                                    <div class="form-group">
                                                        <label for="">Catatan</label>
                                                        <textarea disabled name="note" id="" cols="30" rows="10" class="form-control" style="resize: none; min-height: 200px;"><?= $booking->note; ?></textarea>
                                                    </div>
                                                <?php endif; ?>
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

        <?php require_once '../layout/customer/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/customer/script.php'; ?>

<?php if ($promo): ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="promo-modal" style="display: none;" aria-hidden="true" >
        <div class="modal-dialog" role="document">
            <form class="modal-content" method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title">Promo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Kamu Dapat Promo</p>
                    <?php if ($promo->type == \App\Models\Promo::PROMO_TYPE_DISCOUNT): ?>
                        <p id="promo-price-wrapper">Dengan potongan <b><span id="promo-price"><?= $promo->price; ?></span></b></p>
                    <?php endif; ?>
                    <p id="promo-description"><?= $promo->description; ?></p>
                    <p><span class="badge badge-warning">Promo didapatkan saat melakukan full pembayaran</span></p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
</body>
</html>


