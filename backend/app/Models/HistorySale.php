<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'memo'
    ];

    public static function findByItemID($item_id) {
        return self::query()
            ->where('item_id', $item_id)
            ->first();
    }
}
