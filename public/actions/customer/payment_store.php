<?php

require_once '../../../server.php';

$roomId    = $_POST['room_id'];
$bookingId = $_POST['booking_id'];
$proof     = $_FILES['proof'];

$filename = str_random(40) . ".jpg";

if (move_uploaded_file($proof['tmp_name'], "../../uploads/images/payments/" . $filename)) {

    \App\Models\Payment::instance()->create([
        "room_id"    => $roomId,
        "booking_id" => $bookingId,
        "proof"      => $filename,
    ]);
}

?>
<!doctype html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal/minimal.css" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    Swal.fire(
        'Pemesanan berhasil',
        'Kamu akan diarahkan ke halaman pemesanan',
        'success'
    ).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        window.location.href = '<?= route('home.index'); ?>'
    })
</script>
</body>
</html>

