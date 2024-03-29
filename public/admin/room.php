<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
        $rooms = \App\Models\Room::instance()->with('image')->getAll();
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
                    <h1>Kamar</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Kamar</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Kamar</h4>
                                    <?php if (\App\Models\User::isAdmin()): ?>
                                        <div class="card-header-action">
                                            <a href="<?= route('admin.rooms.form'); ?>" class="btn btn-primary">Tambah Kamar</a>
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
                                                        <th>Nomor</th>
                                                        <th>Foto</th>
                                                        <th>Nama</th>
                                                        <th>Harga</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($rooms as $room): ?>
                                                            <tr>
                                                                <td><?= $room->room_number; ?></td>
                                                                <td><img src="../../uploads/images/rooms/<?= $room->image->name; ?>" alt="" style="width: 150px; height: 150px;"></td>
                                                                <td><?= $room->name; ?></td>
                                                                <td><?= format_currency($room->price); ?></td>
                                                                <td>
                                                                    <?php if (\App\Models\User::isAdmin()): ?>
                                                                        <a href="<?= route('admin.rooms.form') . '?' . http_build_query(['id' => $room->id]); ?>" class="btn btn-primary"><i class="fa fa-pen"></i></a>
                                                                        <button data-toggle="modal" data-target="#destroy-modal" data-url="<?= route('admin.rooms.destroy') . '?' . http_build_query(['id' => $room->id]); ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                                                                    <?php endif; ?>
                                                                    <a href="<?= route('admin.rooms.facilities.index') . '?' . http_build_query(['room_id' => $room->id]); ?>" class="btn btn-success"><i class="fa fa-list"></i></a>
                                                                    <a href="<?= route('admin.rooms.galleries.index') . '?' . http_build_query(['room_id' => $room->id]); ?>" class="btn btn-primary"><i class="fa fa-image"></i></a>
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
                        <p>Hapus ruangan?</p>
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