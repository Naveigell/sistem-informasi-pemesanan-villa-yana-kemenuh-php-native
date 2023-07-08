<?php

require_once '../../../server.php';

$name      = $_POST['name'];
$phone     = $_POST['phone'];
$address   = $_POST['address'];
$email     = $_POST['email'];
$roomId    = $_POST['room_id'];
$promoId   = $_POST['promo_id'] ? (int) $_POST['promo_id'] : null;
$startDate = $_POST['start_date'];
$endDate   = $_POST['end_date'];
$note      = $_POST['note'];

$identityCard = $_FILES['identity_card'];
$downPayment  = $_FILES['down_payment'];

$identityCardFilename = str_random(40) . ".jpg";

if ($identityCard['name']) {

    if (!file_exists("../../uploads/images/identity_cards")) {
        mkdir("../../uploads/images/identity_cards/", 0777, true);
    }

    move_uploaded_file($identityCard['tmp_name'], "../../uploads/images/identity_cards/" . $identityCardFilename);
}

$downPaymentFilename = str_random(40) . ".jpg";

if ($downPayment['name']) {

    if (!file_exists("../../uploads/images/down_payments")) {
        mkdir("../../uploads/images/down_payments/", 0777, true);
    }

    move_uploaded_file($downPayment['tmp_name'], "../../uploads/images/down_payments/" . $downPaymentFilename);
}

$booking = \App\Models\Booking::instance()->create([
    "start_date"    => $startDate,
    "end_date"      => $endDate,
    "room_id"       => $roomId,
    "promo_id"      => $promoId,
    "user_id"       => \Lib\Session\Session::get('user')['id'],
    "identity_card" => $identityCardFilename,
    "down_payment"  => $downPaymentFilename,
    "name"          => $name,
    "email"         => $email,
    "phone"         => $phone,
    "address"       => $address,
    "note"          => $note,
    "created_at"    => date('Y-m-d'),
]);

try {
    $mail = new \Lib\Email\Mail();
    $mail->subject("Villa Yana Kemenuh - Pemesanan berhasil!");
    $mail->addAddress($email, $name);
    $mail->view('../../layout/email/order_success.php', compact('booking'));
    $mail->send();
} catch (Exception $e) {
    die($e->getMessage());
}

redirect($routes['rooms.payment.detail'] . '?' . http_build_query(["room_id" => $roomId, "booking_id" => $booking->id]));