<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Booking extends Model
{
    use Singleton;

    protected $table = 'bookings';

    protected $fillable = ['room_id', 'start_date', 'end_date', 'status'];
}