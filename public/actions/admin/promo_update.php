<?php

require_once '../../../server.php';

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];

\App\Models\Promo::instance()->raw("UPDATE promos SET title = ?, description = ?, price = ?, start_date = ?, end_date = ? WHERE id = ?", [
    $title,
    $description,
    $price,
    $startDate,
    $endDate,
    $_GET['id']
]);

redirect($routes['admin.promos.index']);