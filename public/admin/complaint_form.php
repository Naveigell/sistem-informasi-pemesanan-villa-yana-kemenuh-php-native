<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
        $complaint = \App\Models\Complaint::instance()->raw("SELECT * FROM complaints WHERE id = ?", [$_GET['complaint_id']])->fetch();
        $complaintDescriptions = [];

        \App\Models\Complaint::instance()->raw("UPDATE complaints SET is_read = 1 WHERE id = ?", [$_GET['complaint_id']])->fetch();

        if ($complaint) {
            $complaintDescriptions = \App\Models\ComplaintDescription::instance()->raw("SELECT * FROM complaint_descriptions WHERE complaint_id = ?", [$complaint['id']])->fetchAll();
        }

        $userIds = array_map(function ($complaintDescription) {
            return $complaintDescription['user_id'];
        }, $complaintDescriptions);

        $userIds = array_unique($userIds);

        $users = [];

        if (count($userIds) > 0) {
            $userIds = join(',', $userIds);
            $users = \App\Models\User::instance()->raw("SELECT * FROM users WHERE users.id IN ({$userIds})")->fetchAll();
        }
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
                                    <?php foreach ($complaintDescriptions as $index => $description): ?>
                                        <?php
                                        $user = array_filter($users, function ($user) use ($description) {
                                            return $user['id'] == $description['user_id'];
                                        });

                                        $user = reset($user);
                                        ?>
                                        <?php if ($user): ?>
                                            <?php if ($user['role'] == \App\Models\User::ROLE_CUSTOMER): ?>
                                                <?php if ($description['description']): ?>
                                                    <div class="mb-1">
                                                        <div>
                                                            <span class="">Customer: <?= $user['name']; ?></span>
                                                            <br>
                                                            <div class="badge badge-light mb-3 p-3 mt-1">
                                                                <div><?= $description['description']; ?></div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($description['image']): ?>
                                                    <div class="m-0 p-0 d-flex justify-content-start mb-4">
                                                        <span class=""></span>
                                                        <br>
                                                        <div style="border: 1px dashed #cccccc; border-radius: 5px;">
                                                            <img src="<?= asset('uploads/images/complaints/' . $description['image']); ?>" alt="" style="width: 200px; height: 200px;">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php elseif (in_array($user['role'], [\App\Models\User::ROLE_STAFF, \App\Models\User::ROLE_ADMIN])): ?>
                                                <?php if ($description['description']): ?>
                                                    <div class="m-0 p-0 d-flex justify-content-end mb-4">
                                                        <span class=""></span>
                                                        <br>
                                                        <div class="badge badge-success p-3">
                                                            <div><?= $description['description']; ?></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($description['image']): ?>
                                                    <div class="m-0 p-0 d-flex justify-content-end mb-4">
                                                        <span class=""></span>
                                                        <br>
                                                        <div style="border: 1px dashed #cccccc; border-radius: 5px;">
                                                            <img src="<?= asset('uploads/images/complaints/' . $description['image']); ?>" alt="" style="width: 200px; height: 200px;">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <form action="<?= route('admin.complaints.store') . '?' . http_build_query($_GET); ?>" class="" method="post" enctype="multipart/form-data">
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label for="">Gambar</label>
                                                <input type="file" class="form-control" name="image" accept="image/png,image/jpg,image/jpg">
                                            </div>
                                            <div class="form-group col-12">
                                                <textarea name="description" id="" cols="30" rows="10" placeholder="Tulis Komplain .." class="form-control" style="min-height: 200px; resize: none;"></textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                            </div>
                                        </div>
                                    </form>
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