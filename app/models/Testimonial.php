<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Testimonial extends Model
{
    use Singleton;

    protected $table = 'testimonials';

    protected $fillable = ['name', 'description', 'star'];
}