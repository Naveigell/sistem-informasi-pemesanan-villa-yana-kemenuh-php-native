<?php

require_once '../../../server.php';

\App\Models\RoomImage::instance()->raw("DELETE FROM room_images WHERE id = ?", [$_GET['id']]);

redirect($routes['admin.rooms.galleries.index'] . '?' . http_build_query(['room_id' => $_GET['room_id']]));