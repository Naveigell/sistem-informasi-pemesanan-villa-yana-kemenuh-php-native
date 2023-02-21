<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Complaint extends Model
{
    use Singleton;

    const COMPLAINT_TYPE_CUSTOMER = 'customer';
    const COMPLAINT_TYPE_ADMIN    = 'admin';

    protected $table = 'complaints';

    protected $fillable = ['user_id', 'room_id', 'booking_id', 'complaint_type', 'description'];
}