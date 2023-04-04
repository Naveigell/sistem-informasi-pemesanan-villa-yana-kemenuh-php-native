<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>
    <?php
        $testimonials = \App\Models\Testimonial::instance()->getAll();
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
                    <h1>Testimonial</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Testimonial</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Testimonial</h4>
                                    <div class="card-header-action">
                                        <a href="<?= route('admin.testimonials.form'); ?>" class="btn btn-primary">Tambah Testimoni</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-md dataTable" id="table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Deskripsi</th>
                                            <th>Bintang</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($testimonials as $index => $testimonial): ?>
                                            <tr>
                                                <td><?= $index + 1; ?></td>
                                                <td><?= $testimonial->name; ?></td>
                                                <td><?= $testimonial->description; ?></td>
                                                <td>
                                                    <?php foreach (range(1, 5) as $i): ?>
                                                        <i class="fa fa-star testimonial-stars" <?php if ($i <= $testimonial->star): ?> style="color: darkorange;" <?php endif; ?>></i>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#destroy-modal" data-url="<?= route('admin.testimonials.destroy') . '?' . http_build_query(['testimonial_id' => $testimonial->id]); ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
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
                        <p>Hapus testimoni?</p>
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
    $('#table-1').on('click', '.btn-delete', function () {
        var url = $(this).data('url');

        $('#destroy-modal form').attr('action', url);
    });
</script>
</body>
</html>