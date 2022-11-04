<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryReturn extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'staff_id',
        'request_on',
        'carrier_name',
        'tracking_number',
        'estimated_arrival_on',
        'memo',
    ];

    public static function findByItemID($item_id) {
        return self::query()
            ->where('item_id', $item_id)
            ->first();
    }
}
