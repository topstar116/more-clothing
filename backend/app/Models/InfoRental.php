<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoRental extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'staff_id',
        'price',
        'title',
        'detail',
    ];

    public static function findByID($info_rental_id) {
        return self::query()
                ->where('id', $info_rental_id)
                ->first();
    }

    public static function findByItemID($item_id) {
        return self::query()
            ->where('item_id', $item_id)
            ->whereNull('deleted_at')
            ->first();
    }
}
