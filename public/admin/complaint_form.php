<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
        $booking    = \App\Models\Booking::instance()->raw("SELECT * FROM bookings WHERE id = ?", [$_GET['booking_id']])->fetch();
        $user       = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id = ?", [$booking['user_id']])->fetch();
        $room       = \App\Models\Room::instance()->raw("SELECT * FROM rooms WHERE id = ?", [$booking['room_id']])->fetch();
        $complaints = \App\Models\Complaint::instance()->raw("SELECT * FROM complaints WHERE booking_id = ?", [$booking['id']])->fetchAll();
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
                    <h1>Komplain</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Komplain</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Komplain - <?= $room['room_number']; ?></h4>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($complaints as $complaint): ?>
                                        <div class="card p-3">
                                            <div class="alert alert-light">
                                                <?= $complaint['description']; ?>
                                            </div>
                                            <div class="row pl-3">
                                                <button data-url="<?= route('admin.complaints.update') . '?' . http_build_query(['complaint_id' => $complaint['id']]); ?>" class="btn btn-primary btn-finish" data-toggle="modal" data-target="#complaint-finish-modal">Selesaikan</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="complaint-finish-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="modal-content" method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Selesai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-text">Selesaikan komplain?</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Iya</button>
                    </div>
                </form>
            </div>
        </div>

        <?php require_once '../layout/admin/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/admin/script.php'; ?>
<script>
    $('.btn-finish').on('click', function () {
        $('#complaint-finish-modal form').attr('action', $(this).data('url'));
    })
</script>
</body>
</html>