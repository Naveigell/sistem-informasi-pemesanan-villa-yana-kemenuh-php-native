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
        $complaints = \App\Models\Complaint::instance()->raw("SELECT * FROM complaints WHERE booking_id = ?", [$_GET['booking_id']])->fetchAll();
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
                                    <?php foreach ($complaints as $index => $complaint): ?>
                                        <div class="alert alert-light">
                                            <div style="float: left"><?= $index + 1; ?>. <?= $complaint['description']; ?></div>
                                            <div style="float: right;">
                                                <?php if ($complaint['status'] == \App\Models\Complaint::COMPLAINT_STATUS_NOT_FINISHED): ?>
                                                    <span class="badge badge-dark">Sedang di proses</span>
                                                <?php else: ?>
                                                    <span class="badge badge-success">Selesai</span>
                                                <?php endif; ?>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </div>
                                    <?php endforeach; ?>
                                    <form action="<?= route('customers.orders.complaints.store') . '?' . http_build_query($_GET); ?>" class="" method="post">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <textarea required name="description" id="" cols="30" rows="10" placeholder="Tulis Komplain .." class="form-control" style="min-height: 200px; resize: none;"></textarea>
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


