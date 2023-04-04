<?php

require_once '../../../server.php';

$name        = $_POST['name'];
$description = $_POST['name'];
$star        = $_POST['star'];

\App\Models\Testimonial::instance()->create([
    "name" => $name,
    "description" => $description,
    "star" => $star,
]);

redirect($routes['admin.testimonials.index']);