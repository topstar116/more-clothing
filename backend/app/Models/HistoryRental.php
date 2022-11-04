<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRental extends Model
{
    use HasFactory;

    public static function findByItemID($item_id) {
        return self::query()
            ->where('item_id', $item_id)
            ->first();
    }
}
