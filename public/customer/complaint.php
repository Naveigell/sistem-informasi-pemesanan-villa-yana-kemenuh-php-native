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
        $complaint = \App\Models\Complaint::instance()->raw("SELECT * FROM complaints WHERE booking_id = ?", [$_GET['booking_id']])->fetch();
        $complaintDescriptions = $users = [];

        if ($complaint) {
            $complaintDescriptions = \App\Models\ComplaintDescription::instance()->raw("SELECT * FROM complaint_descriptions WHERE complaint_id = ?", [$complaint['id']])->fetchAll();
        }

        $userIds = array_map(function ($complaintDescription) {
            return $complaintDescription['user_id'];
        }, $complaintDescriptions);

        $userIds = array_unique($userIds);

        if (count($userIds)) {
            $userIds = join(',', $userIds);
            $users = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id IN ({$userIds})")->fetchAll();
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
                    <h2 class="section-title">Kamar - UIDP</h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Komplain</h4>
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
                                            <?php if (in_array($user['role'], [\App\Models\User::ROLE_STAFF, \App\Models\User::ROLE_ADMIN])): ?>
                                                <?php if ($description['description']): ?>
                                                    <div class="mb-1">
                                                        <div>
                                                            <span class="">Staff: <?= $user['name']; ?></span>
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
                                            <?php elseif ($user['role'] == \App\Models\User::ROLE_CUSTOMER): ?>
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
                                    <form action="<?= route('customers.orders.complaints.store') . '?' . http_build_query($_GET); ?>" class="" method="post" enctype="multipart/form-data">
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

        <?php require_once '../layout/customer/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/customer/script.php'; ?>

</body>
</html>


