<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>

    <?php
    $fillable = \App\Models\Facility::instance()->getFillable();
    $facility = array_combine(\App\Models\Facility::instance()->getFillable(), array_fill(0, count($fillable), ""));

    if (array_key_exists("id", $_GET)) {
        $facility = \App\Models\Facility::instance()->raw("SELECT * FROM facilities WHERE id = ?", [$_GET['id']])->fetch();
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
                    <h1>Default Layout</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="#">Layout</a></div>
                        <div class="breadcrumb-item">Default Layout</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form</h4>
                                </div>
                                <form method="post" class="card-body" action="<?= array_key_exists("id", $_GET) ? route('admin.rooms.facilities.update') . '?' . http_build_query($_GET) : route('admin.rooms.facilities.store') . '?' . http_build_query($_GET); ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="inputAddress">Nama Fasilitas</label>
                                        <input type="text" name="name" value="<?= $facility['name']; ?>" class="form-control">
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