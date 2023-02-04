<?php

require_once '../../../server.php';

$image       = $_FILES['image'];
$roomNumber  = $_POST['room_number'];
$name        = $_POST['name'];
$price       = $_POST['price'];
$description = $_POST['description'];

$filename = str_random(40) . ".jpg";

if (move_uploaded_file($image['tmp_name'], "../../uploads/images/rooms/" . $filename)) {
    $room = \App\Models\Room::instance()->create([
        "room_number" => $roomNumber,
        "name"        => $name,
        "price"       => $price,
        "description" => $description,
    ]);

    \App\Models\RoomImage::instance()->create([
        "room_id" => $room->id,
        "name"    => $filename,
    ]);

    redirect($routes['admin.rooms.index']);
}