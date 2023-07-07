<?php

require_once '../../../server.php';

$avatar = $_FILES['avatar'];
$filename = str_random(40) . ".jpg";

if ($avatar) {
    if (!file_exists("../../uploads/images/biodata/profile")) {
        mkdir("../../uploads/images/biodata/profile", 0777, true);
    }

    move_uploaded_file($avatar['tmp_name'], "../../uploads/images/biodata/profile/{$filename}");

    \App\Models\Biodata::instance()->raw("UPDATE biodatas SET avatar = ? WHERE user_id = ?", [$filename, \Lib\Session\Session::get('user')['id']]);
}

redirect($routes['customers.profile.index']);