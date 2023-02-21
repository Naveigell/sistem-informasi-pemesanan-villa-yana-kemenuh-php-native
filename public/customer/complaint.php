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
                                    <form action="<?= route('customers.orders.complaints.store') . '?' . http_build_query($_GET); ?>" class="" method="post">
                                        <div class="row">
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


