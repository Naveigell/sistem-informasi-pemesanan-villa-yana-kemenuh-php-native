<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class RoomImage extends Model
{
    use Singleton;

    protected $table = 'room_images';

    protected $fillable = ['room_id', 'name'];
}