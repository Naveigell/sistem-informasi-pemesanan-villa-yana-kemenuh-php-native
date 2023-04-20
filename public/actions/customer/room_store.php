<?php

require_once '../../../server.php';

$name      = $_POST['name'];
$phone     = $_POST['phone'];
$address   = $_POST['address'];
$email     = $_POST['email'];
$roomId    = $_POST['room_id'];
$startDate = $_POST['start_date'];
$endDate   = $_POST['end_date'];
$note      = $_POST['note'];

$booking = \App\Models\Booking::instance()->create([
    "start_date" => $startDate,
    "end_date"   => $endDate,
    "room_id"    => $roomId,
    "user_id"    => \Lib\Session\Session::get('user')['id'],
    "name"       => $name,
    "email"      => $email,
    "phone"      => $phone,
    "address"    => $address,
    "note"       => $note,
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