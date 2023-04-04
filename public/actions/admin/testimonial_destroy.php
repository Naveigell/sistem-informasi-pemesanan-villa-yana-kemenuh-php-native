<?php

require_once '../../../server.php';

\App\Models\Testimonial::instance()->raw("DELETE FROM testimonials WHERE id = ?", [$_GET['testimonial_id']]);

redirect($routes['admin.testimonials.index']);