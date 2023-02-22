<?php

require_once '../../../server.php';

\App\Models\Complaint::instance()->raw("UPDATE complaints SET status = 1 WHERE id = ?", [$_GET['complaint_id']]);

redirect($routes['admin.complaints.index']);
