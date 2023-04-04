<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once "../layout/admin/style.php"; ?>
    <style>
        .star-active {
            color: #f37809;
        }
    </style>
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
                                <form method="post" class="card-body" action="<?= route('admin.testimonials.store'); ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="inputAddress">Nama</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Description</label>
                                        <textarea name="description" id="" cols="30" rows="50" class="form-control" style="height: 200px !important; resize: none;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <?php foreach (range(1, 5) as $i): ?>
                                            <i class="fa fa-star star" style="font-size: 20px; padding: 1px; cursor: pointer;"></i>
                                        <?php endforeach; ?>
                                        <input type="hidden" id="star" name="star">
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
<script>
    var stars = $('.star');

    stars.on('click', function () {
        let elementIndex = $(this).index();

        $('#star').val(elementIndex + 1);

        stars.removeClass('star-active');
        stars.each(function (index) {
            if (index <= elementIndex) {
                $(this).addClass('star-active');
            }
        });
    });
</script>
</body>
</html>