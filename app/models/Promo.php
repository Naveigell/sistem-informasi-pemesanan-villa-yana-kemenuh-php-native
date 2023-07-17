<?php

namespace App\Models;

use Lib\Application\Singleton;
use Lib\Model\Model;

class Promo extends Model
{
    use Singleton;

    const PROMO_TYPE_DISCOUNT = 1;
    const PROMO_TYPE_INCLUDE = 2;

    protected $table = 'promos';

    protected $fillable = ['title', 'description', 'type', 'price', 'start_date', 'end_date'];

    public function getTypeFormatted()
    {
        if ($this->type == self::PROMO_TYPE_DISCOUNT) {
            return 'Diskon';
        }

        return 'Include';
    }
}