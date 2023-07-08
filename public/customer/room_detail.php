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

        $promos = \App\Models\Promo::instance()->getAllToArray();

        // create price formatted in every promo
        foreach ($promos as $index => $promo) {
            $promos[$index]['price_formatted'] = number_format($promo['price'], 0, ',', '.');
        }

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
                                                <div class="zoom carousel-item <?= $index == 0 ? 'active' : ''; ?>">
                                                    <img class="d-block w-100" src="../uploads/images/rooms/<?= $image->name; ?>" style="height: 650px !important; object-fit: cover;">
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
                                                <div class="alert alert-warning col-12" id="alert-promo" style="display: none;"><i class="fa fa-certificate"></i> Kamu dapat promo</div>

                                                <form action="<?= route('rooms.bookings.store'); ?>" class="col-lg-8 col-md-12" method="post" enctype="multipart/form-data">
                                                    <h6 class="text text-success">Form Pemesanan</h6>
                                                    <input type="hidden" name="room_id" value="<?= $_GET['room_id']; ?>">
                                                    <input type="hidden" name="start_date" id="from" value="<?= $_GET['from']; ?>">
                                                    <input type="hidden" name="end_date" id="to" value="<?= $_GET['to']; ?>">
                                                    <input type="hidden" name="promo_id" value="" id="promo-id">
                                                    <div class="form-group">
                                                        <label for="">Nama</label>
                                                        <input required type="text" name="name" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Alamat</label>
                                                        <input required type="text" name="address" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input required type="email" name="email" class="form-control" value="<?= \Lib\Session\Session::get('user')['email']; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">No Telp</label>
                                                        <input required type="text" name="phone" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Upload Ktp</label>
                                                        <input required type="file" name="identity_card" accept="image/png,image/jpg,image/jpeg" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Upload Dp</label>
                                                        <input required type="file" name="down_payment" accept="image/png,image/jpg,image/jpeg" class="form-control">
                                                        <small class="text text-muted">Upload dp minimal 10% harga Rp. <?= format_currency($room->price * 0.1); ?>)</small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Catatan <small>(optional)</small></label>
                                                        <textarea name="note" id="" cols="30" rows="10" class="form-control" style="resize: none; min-height: 200px;"></textarea>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>

                                                        <?php if ($from && $to && !$isBooked && $roomId): ?>
                                                            <button data-toggle="modal" data-target="#promo-modal" type="button" class="btn btn-warning" id="button-promo" style="display: none;"><i class="fa fa-certificate"></i> Cek Deskripsi Promo</button>
                                                        <?php endif; ?>
                                                    </div>

                                                    <input type="hidden" id="all-dates" value='<?= json_encode($promos); ?>'>
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
                        <p>Dengan potongan <b><span id="promo-price"></span></b></p>
                        <p id="promo-description"></p>
                        <p><span class="badge badge-warning">Promo didapatkan saat melakukan full pembayaran</span></p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            var dateElement = document.getElementById('all-dates').value;

            // if date element is not exists, it's mean the user doesn't choose any date
            if (dateElement) {
                var allDates = JSON.parse(document.getElementById('all-dates').value);

                for (var date of allDates) {

                    var startDate = moment(date.start_date, "YYYY-MM-DD");
                    var endDate = moment(date.end_date, "YYYY-MM-DD");

                    var from = moment(document.getElementById('from').value);
                    var to = moment(document.getElementById('to').value);

                    if (from.isBetween(startDate, endDate) || to.isBetween(startDate, endDate)) {
                        document.getElementById('promo-id').value = date.id;
                        document.getElementById('promo-description').innerHTML = date.description;

                        document.getElementById('alert-promo').style.display = 'block';
                        document.getElementById('button-promo').style.display = 'inline-block';

                        document.getElementById('promo-price').innerHTML = date.price_formatted;
                    }
                }
            }
        </script>

        <?php require_once '../layout/customer/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/customer/script.php'; ?>

</body>
</html>


