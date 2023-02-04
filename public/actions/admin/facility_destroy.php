<?php

require_once '../../../server.php';

\App\Models\Facility::instance()->raw("DELETE FROM facilities WHERE id = ?", [$_GET['id']]);

redirect($routes['admin.rooms.facilities.index'] . '?' . http_build_query(['room_id' => $_GET['room_id']]));