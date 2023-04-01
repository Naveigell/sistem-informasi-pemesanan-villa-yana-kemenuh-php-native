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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.5/css/lightslider.min.css">
</head>

<body class="layout-3">
<div id="app">
    <div class="main-wrapper container">

        <?php require_once './layout/customer/header.php'; ?>

        <!-- Main Content -->
        <div class="main-content" style="min-height: 670px;">
            <section class="section">
                <div class="section-body">
                    <ul id="vertical">
                        <?php foreach ([
                                        'https://ik.imagekit.io/tvlk/apr-asset/dgXfoyh24ryQLRcGq00cIdKHRmotrWLNlvG-TxlcLxGkiDwaUSggleJNPRgIHCX6/hotel/asset/10035208-9f4f2254ffb578d4fad8513296905872.jpeg?_src=imagekit&tr=dpr-2,c-at_max,h-488,q-40,w-768',
                                        'https://ik.imagekit.io/tvlk/apr-asset/dgXfoyh24ryQLRcGq00cIdKHRmotrWLNlvG-TxlcLxGkiDwaUSggleJNPRgIHCX6/hotel/asset/10035208-657d192f346ce81221d8b31b92c66f84.jpeg?_src=imagekit&tr=dpr-2,c-at_max,h-360,q-40,w-640',
                                        'https://ik.imagekit.io/tvlk/generic-asset/dgXfoyh24ryQLRcGq00cIdKHRmotrWLNlvG-TxlcLxGkiDwaUSggleJNPRgIHCX6/hotel/asset/10035208-ccfbc40df67cd4a65bcce9df9e2fb1c9.jpeg?_src=imagekit&tr=dpr-2,c-at_max,h-360,q-40,w-640',
                                        'https://ik.imagekit.io/tvlk/apr-asset/dgXfoyh24ryQLRcGq00cIdKHRmotrWLNlvG-TxlcLxGkiDwaUSggleJNPRgIHCX6/hotel/asset/10035208-15ccc8d358abd0ee0e7891e0ee367335.jpeg?_src=imagekit&tr=dpr-2,c-at_max,h-360,q-40,w-640',
                                       ] as $link): ?>
                            <li data-thumb="<?= $link; ?>">
                                <img src="<?= $link; ?>" />
                            </li>
<!--                            <li data-thumb="--><?//= DOMAIN . '/assets/img/banner/' . $image; ?><!--">-->
<!--                                <img src="--><?//= DOMAIN . '/assets/img/banner/' . $image; ?><!--" />-->
<!--                            </li>-->
                        <?php endforeach; ?>
                    </ul>
                    <h2 class="section-title mt-5">Kamar</h2>
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
                    <h2 class="section-title">Lokasi</h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6339.753405183006!2d115.28542676915103!3d-8.553900351495214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd21603cc98c3c3%3A0xcc26851b4073da90!2sYana%20Villas%20Kemenuh%20by%20Pramana!5e0!3m2!1sen!2sid!4v1680359290043!5m2!1sen!2sid" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </section>
        </div>

        <?php require_once './layout/customer/footer.php'; ?>

    </div>
</div>

<?php require_once './layout/customer/script.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.5/js/lightslider.min.js"></script>
<script>
    $(document).ready(function() {
        $('#vertical').lightSlider({
            gallery:true,
            item:1,
            vertical:true,
            // verticalHeight:295,
            // vThumbWidth:50,
            thumbItem:8,
            thumbMargin:4,
            slideMargin:0
        });
    });
</script>
</body>
</html>


