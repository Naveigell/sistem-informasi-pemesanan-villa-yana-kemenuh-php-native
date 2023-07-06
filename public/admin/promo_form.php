<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
        $fillable = \App\Models\Promo::instance()->getFillable();
        $promo = array_combine(\App\Models\Promo::instance()->getFillable(), array_fill(0, count($fillable), ""));

        if (array_key_exists("id", $_GET)) {
            $promo = \App\Models\Promo::instance()->raw("SELECT * FROM promos WHERE id = ?", [$_GET['id']])->fetch();
        }
    ?>

</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">

        <?php require_once '../layout/admin/header.php'; ?>
        <?php require_once '../layout/admin/sidebar.php'; ?>

        <style>
            textarea {
                resize: none;
            }
        </style>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Promo</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="#">Promo</a></div>
                        <div class="breadcrumb-item">Promo</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form</h4>
                                </div>
                                <form method="post" class="card-body" action="<?= array_key_exists("id", $_GET) ? route('admin.promos.update') . '?' . http_build_query($_GET) : route('admin.promos.store'); ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="inputAddress">Judul</label>
                                        <input required type="text" name="title" value="<?= $promo['title']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">deskripsi</label>
                                        <textarea required name="description" id="" cols="30" rows="50" class="form-control" style="height: 200px !important; resize: none;"><?= $promo['description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Potongan Harga</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp.</div>
                                            </div>
                                            <input required type="text" name="price" value="<?= (int) $promo['price']; ?>" class="form-control nominal">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Dari Tanggal</label>
                                        <input required type="date" name="start_date" value="<?= \Carbon\Carbon::parse($promo['start_date'])->format('Y-m-d'); ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Sampai Tanggal</label>
                                        <input required type="date" name="end_date" value="<?= \Carbon\Carbon::parse($promo['end_date'])->format('Y-m-d'); ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
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