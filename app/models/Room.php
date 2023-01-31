<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Room extends Model
{
    use Singleton;

    protected $table = 'rooms';

    protected $fillable = ['room_number', 'name', 'price', 'description'];

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'room_id');
    }

    public function image()
    {
        return $this->hasOne(RoomImage::class, 'room_id');
    }
}