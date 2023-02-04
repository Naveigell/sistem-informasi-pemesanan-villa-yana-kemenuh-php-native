<?php

require_once '../../../server.php';

$image       = $_FILES['image'];
$name        = $_POST['name'];
$price       = $_POST['price'];
$description = $_POST['description'];

$filename = str_random(40) . ".jpg";

if ($image['name']) {
    move_uploaded_file($image['tmp_name'], "../../uploads/images/rooms/" . $filename);

    \App\Models\RoomImage::instance()->raw("UPDATE room_images SET name = ? WHERE room_id = ? AND is_main = 1", [$filename, $_GET['id']]);
}

\App\Models\Room::instance()->raw("UPDATE rooms SET name = ?, price = ?, description = ? WHERE id = ?", [$name, $price, $description, $_GET['id']]);

redirect($routes['admin.rooms.index']);