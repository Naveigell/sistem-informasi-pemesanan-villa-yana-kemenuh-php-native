<?php

require_once '../server.php';

$rooms = \App\Models\Room::instance()->with('image')->getAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout › Top Navigation — Stisla</title>

    <?php require_once './layout/customer/style.php'; ?>
</head>

<body class="layout-3">
<div id="app">
    <div class="main-wrapper container">

        <?php require_once './layout/customer/header.php'; ?>

        <!-- Main Content -->
        <div class="main-content" style="min-height: 670px;">
            <section class="section">
                <div class="section-body">
                    <h2 class="section-title">Kamar</h2>
                    <div class="row">
                        <?php foreach ($rooms as $room): ?>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <article class="article article-style-b">
                                    <div class="article-header">
                                        <div class="article-image" data-background="uploads/images/rooms/<?= $room->image->name; ?>" style="background-image: url('uploads/images/rooms/<?= $room->image->name; ?>');">
                                        </div>
                                    </div>
                                    <div class="article-details">
                                        <div class="article-title">
                                            <h2><a href="<?= route('rooms.detail') . '?' . http_build_query(['room_id' => $room->id]); ?>" style="overflow-wrap: break-word;"><?= $room->name; ?></a></h2>
                                        </div>
                                        <p><?= $room->description; ?></p>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </div>

        <?php require_once './layout/customer/footer.php'; ?>

    </div>
</div>

<?php require_once './layout/customer/script.php'; ?>

</body>
</html>


