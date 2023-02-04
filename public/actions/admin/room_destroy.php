<?php

require_once '../../../server.php';

\App\Models\Room::instance()->raw("DELETE FROM rooms WHERE id = ?", [$_GET['id']]);

redirect($routes['admin.rooms.index']);