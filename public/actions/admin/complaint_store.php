<?php

require_once '../../../server.php';

$complaintId = $_GET['complaint_id'];
$bookingId   = $_GET['booking_id'];
$roomId      = $_GET['room_id'];
$description = array_key_exists('description', $_POST) ? $_POST['description'] : null;
$image       = array_key_exists('image', $_FILES) ? $_FILES['image'] : null;

$imageName = null;

if ($description || $image['tmp_name']) {
    if ($image['tmp_name']) {
        if (!file_exists("../../uploads/images/complaints")) {
            mkdir("../../uploads/images/complaints/", 0777, true);
        }

        $imageName = str_random(30) . '.jpg';

        move_uploaded_file($image['tmp_name'], "../../uploads/images/complaints/" . $imageName);
    }

    \App\Models\ComplaintDescription::instance()->create([
        "user_id"        => \Lib\Session\Session::get('user')['id'],
        "complaint_id"   => $complaintId,
        "image"          => $imageName,
        "description"    => $description,
    ]);
}

redirect($routes['admin.complaints.show']  . '?' . http_build_query(['booking_id' => $bookingId, 'room_id' => $roomId, 'complaint_id' => $complaintId]));