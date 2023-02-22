<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Booking extends Model
{
    use Singleton;

    const STATUS_NOT_ACC  = 0;
    const STATUS_ACC      = 1;
    const STATUS_CANCELED = 2;
    const STATUS_REJECTED = 3;

    const STATUSES = [
        self::STATUS_NOT_ACC  => "Belum di acc",
        self::STATUS_ACC      => "Di acc",
        self::STATUS_CANCELED => "Dibatalkan",
        self::STATUS_REJECTED => "Ditolak",
    ];

    protected $table = 'bookings';

    protected $fillable = ['room_id', 'user_id', 'start_date', 'end_date', 'status'];

    public function getStatusByNumber($status)
    {
        return self::STATUSES[$status];
    }
}