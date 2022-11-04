<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class InfoSale extends Model
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
        'sale_url',
        'sale_price',
        'start_on',
    ];

    public static function findByItemID($item_id) {
        return self::query()
            ->where('item_id', $item_id)
            ->whereNull('deleted_at')
            ->first();
    }
}
