<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Complaint extends Model
{
    use Singleton;

    const COMPLAINT_STATUS_NOT_FINISHED = 0;
    const COMPLAINT_STATUS_FINISHED     = 1;

    protected $table = 'complaints';

    protected $fillable = ['room_id', 'booking_id', 'status'];
}