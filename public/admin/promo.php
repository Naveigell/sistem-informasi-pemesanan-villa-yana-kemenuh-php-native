<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
        $promos = \App\Models\Promo::instance()->getAll();
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
                    <h1>Promo</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Promo</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Promo</h4>
                                    <?php if (\App\Models\User::isAdmin()): ?>
                                        <div class="card-header-action">
                                            <a href="<?= route('admin.promos.form'); ?>" class="btn btn-primary">Tambah Promo</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-bordered table-md dataTable" id="table-1">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Judul</th>
                                                        <th>Deskripsi</th>
                                                        <th>Potongan</th>
                                                        <th>Dari Tanggal</th>
                                                        <th>Sampai Tanggal</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($promos as $index => $promo): ?>
                                                            <tr>
                                                                <td><?= $index + 1; ?></td>
                                                                <td><?= $promo->title; ?></td>
                                                                <td><?= $promo->description; ?></td>
                                                                <td>Rp. <?= number_format($promo->price, 0, ',', '.'); ?></td>
                                                                <td><?= \Carbon\Carbon::parse($promo->start_date)->translatedFormat('d F Y'); ?></td>
                                                                <td><?= \Carbon\Carbon::parse($promo->end_date)->translatedFormat('d F Y'); ?></td>
                                                                <td>
                                                                    <a href="<?= route('admin.promos.form') . '?' . http_build_query(['id' => $promo->id]); ?>" class="btn btn-warning"><i class="fa fa-pen"></i></a>
                                                                    <button data-toggle="modal" data-target="#destroy-modal" data-url="<?= route('admin.promos.destroy') . '?' . http_build_query(['id' => $promo->id]); ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="destroy-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="modal-content" method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Hapus promo?</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        <?php require_once '../layout/admin/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/admin/script.php'; ?>
<script>
    $('.btn-delete').on('click', function () {
        var url = $(this).data('url');

        $('#destroy-modal form').attr('action', url);
    });
</script>
</body>
</html>