<?php

require_once '../../../server.php';

\App\Models\Promo::instance()->raw("DELETE FROM promos WHERE id = ?", [$_GET['id']]);

redirect($routes['admin.promos.index']);
