<?php

require_once '../../../server.php';

$title = $_POST['title'];
$description = $_POST['description'];
$type = $_POST['type'];
$price = $_POST['price'];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];

\App\Models\Promo::instance()->create([
    'title' => $title,
    'description' => $description,
    'type' => $type,
    'price' => $price,
    'start_date' => $startDate,
    'end_date' => $endDate,
]);

redirect($routes['admin.promos.index']);